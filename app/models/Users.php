<?php
    namespace App\Models;
    use Core\Model;
    use Core\Session;
    use Core\Cookie;
    use App\Models\UserSessions;

    class Users extends Model {
        public $profileImage, $location, $marketArea, $businessYear, $businessName, $businessDescription, $serviceDescription,
        $phoneNumber, $verifiedPhoneNumber, $accountNumber, $username, $userType, $auth, $passwordRetrieve, $password,
        $confirmPassword;

        public function __construct()
        {
            parent::__construct('users');
        }

        public function validateRegistration() {
            return [
                'username' => ['display' => 'Full name', 'required' => true, 'isLetters' => true, 'max' => 30],
                'password' => ['display' => 'Password', 'min' => 8, 'required' => true]
            ];
        }

        /**Registers new user */
        public function register() {
            if($this->userType == "Ads") {
                return $this->insert([
                    'profileImage' => $this->profileImage,
                    'location' => $this->location,
                    'marketArea' => $this->marketArea,
                    'businessYear' => $this->businessYear,
                    'businessName' => $this->businessName,
                    'businessDescription' => $this->businessDescription,
                    'serviceDescription' => $this->serviceDescription,
                    'phoneNumber' => $this->phoneNumber,
                    'verifiedPhoneNumber' => $this->verifiedPhoneNumber,
                    'accountNumber' => $this->accountNumber,
                    'userType' => $this->userType,
                    'username' => $this->username,
                    'auth' => $this->auth,
                    'password' => $this->password,
                    'createdAt' => date('Y-m-d H:i:s')
                ]);
            } else {
                return $this->registerFind();
            }
        }

        private function registerFind() {
            return $this->insert([
                'profileImage' => $this->profileImage,
                'phoneNumber' => $this->phoneNumber,
                'verifiedPhoneNumber' => $this->verifiedPhoneNumber,
                'userType' => $this->userType,
                'username' => $this->username,
                'auth' => $this->auth,
                'password' => $this->password,
                'createdAt' => date('Y-m-d H:i:s')
            ]);
        }

        public function validateEdit() {
            if(empty($_FILES["profile_image"]['name'])) $this->is_image_file = false;

            return [
                'username' => ['display' => 'Full name', 'required' => true, 'isLetters' => true, 'max' => 30],
                'profile_image' => ['display' => 'Image', 'isImage' =>  $this->is_image_file, 'size' => 4.5],
            ];
        }

        /**Edit profile */
        public function patch() {
                return $this->update('auth = ?', [$this->auth], 
                [
                    'profileImage' => $this->profileImage,
                    'location' => $this->location,
                    'marketArea' => $this->marketArea,
                    'businessYear' => $this->businessYear,
                    'businessName' => $this->businessName,
                    'businessDescription' => $this->businessDescription,
                    'serviceDescription' => $this->serviceDescription,
                    'phoneNumber' => $this->phoneNumber,
                    'accountNumber' => $this->accountNumber,
                    'userType' => $this->userType,
                    'username' => $this->username,
                ]);
        } 

        public function fetchByPhone($PhoneNumber) {
            $res = $this->query("SELECT auth, businessName, userType, profileImage, id FROM users 
            WHERE verifiedPhoneNumber = ? LIMIT 1", [$PhoneNumber])->getResult();
            if(count($res)) {
                return $res[0];
            }
            return false;
        }

        /**
         * Login user method.
         * 
         * if rememberMe is false, the user cookie is not stored, 
         * Cookie detail is not saved in the database for cookie login
         */
        public function login($rememberMe = false) {
            Session::set(USER_SESSION_NAME, $this->user_id);
            Session::set(ACL, $this->acl);
            if($rememberMe) {
                $hash = md5(uniqid() + random_int(100, 100000));
                $userAgent = Session::getUserAgent();
                Cookie::set(USER_COOKIE_NAME, $hash, USER_COOKIE_EXPIRY);
                $fields = ['session'=>$hash, 'user_agent'=>$userAgent, 'user_id'=>$this->user_id];
                $this->db->query("DELETE FROM user_sessions WHERE user_agent = ? AND user_id = ? ", 
                                [$userAgent, $this->user_id]);
                $this->db->insert('user_sessions', $fields);
            }
        }

        /***
         * Checks if the cookie exists,
         * Login the user owner if true
         */
        public static function getCookieForLogin() {
            $userSession = UserSessions::getUserCookie();
            if($userSession) {
                $user = new self((int)$userSession->user_id);
                if($user) {
                    $user->login();
                }
            }
        }

        /**Logout any user and delete any stored cookie */
        public function logout() {
            $userAgent = Session::getUserAgent();
            $this->db->query("DELETE FROM user_sessions WHERE user_agent = ? AND user_id = ? ", 
                            [$userAgent, Session::get(USER_SESSION_NAME)]);
            Session::delete(USER_SESSION_NAME);
            if(Cookie::exists(USER_COOKIE_NAME)) {
                Cookie::delete(USER_COOKIE_NAME);
            }
            return true;
        }
        
        public function resetPassword() {
            return $this->update('email', $this->email, [
                'pwd_retrieve' => $this->pwd_retrieve,
                'password' => $this->password
            ]);
        }

        public function findUserByID(int $user_id) {
            return $this->findFirst(['conditions'=>'user_id = ?', 'bind'=>[$user_id]]);
        }

        public function fetchUsers($start) {
            return $this->query("SELECT * FROM users LIMIT $start, 20")->getResult();
        }

        public function findUser() {
            return $this->query("SELECT id, username, `password` FROM users 
            WHERE username = ?", [$this->username])->getResult()[0];
        }

        public function fetchAllUsers() {
            return $this->query("SELECT * FROM users")->getResult();
        }

        public function getCount() {
            $res = $this->query("SELECT * FROM users")->getResult();
            return count($res);
        }

        public function banUser(int $user_id) {
            return $this->update('user_id = ?', [$user_id], ['ban_status' => 1]);
        }

        public function stopBanUser(int $user_id) {
            return $this->update('user_id = ?', [$user_id], ['ban_status' => 0]);
        }
        
    }

?>