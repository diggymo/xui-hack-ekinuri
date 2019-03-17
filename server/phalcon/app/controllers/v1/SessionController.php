<?php

namespace App\Controllers\V1;

use ResetEmails;
use ResetPasswords;
use Users;


/**
 * Class SessionController
 * @package App\Controllers\V1
 */
class SessionController extends BaseV1Controller
{
    /**
     * ユーザー登録API
     * なんどやってもOK。
     *
     */
    public function login()
    {
        $params = $this->getJsonParam();
        $name = $params->name;
        $region = $params->region;
        $team = $params->team;

        $user = Users::findFirstByName($name) ?: new Users();
        $user->name = $name;
        $user->region = $region;
        $user->team = $team;
        $user->save();

        $this->success($user)->send();
//
//        if ($this->auth['role'] !== 'GUEST') {
//            $this->error('wrong_params', $this->getFormattedMessage([['message' => 'すでにログインしています']]))->send();
//            return;
//        }
//
//        $isThrottlingTimeout = !SessionRepository::checkThrottlingByIp($this->request->getHeader("X-Forwarded-for"));
//        if ($isThrottlingTimeout) {
//            $this->error('unauthorized', $this->getFormattedMessage([['message' => '一定回数以上のアクセスを検知したので一定時間ログインできません']]))->send();
//            return;
//        }
//
//
//        $param = $this->getJsonParam();
//        // ユーザーを取得
//        $user = SessionService::g()->getLoginUser($param->email, $param->password);
//        if (!$user) {
//            SessionRepository::logThrottlingByIp($this->request->getHeader("X-Forwarded-for"));
//            $this->error('unauthorized', $this->getFormattedMessage([['message' => 'メールアドレスまたはパスワードが間違っています']]))->send();
//            return;
//        }
//
//        // セッションの再設定
//        $user->last_communicated_at = date("Y-m-d H:i:s");
//        $user->update();
//
//        $jwt = SessionRepository::createToken($user);
//        $this->success()->setHeader("Authorization", "Bearer $jwt")->send();
    }




//    /**
//     * メールアドレス更新
//     */
//    public function resetEmail()
//    {
//        $encryptedId = $this->auth['sub'];
//        $user = \Users::findFirstByEncryptedId($encryptedId);
//        $param = $this->getJsonParam();
//        $token = $this->security->getRandom()->base64Safe(250);
//        $expiredTime = date("Y-m-d H:i:s", strtotime(self::EMAIL_EXPIRED_PERIOD));
//        $expiredTimeToFmt = date("Y年m月d日 H時i分", strtotime(self::EMAIL_EXPIRED_PERIOD));
//
//        $reseting = new ResetEmails([
//            'user_id' => $user->id,
//            'email' => $param->email,
//            'expired_time' => $expiredTime,
//            'token' => $token
//        ]);
//
//        if (!$reseting->validation()) {
//            $messages = $this->getFormattedMessage($reseting->getMessages());
//            return $this->error("wrong_params", $messages)->send();
//        }
//
//        // 失敗しても完了メッセージを表示
//        if (!SessionService::g()->sendConfirmEmail($param->email, $expiredTimeToFmt, $token)) {
//            return $this->success()->send();
//        }
//
//        if (!$reseting->create()) {
//            return $this->error(500)->send();
//        }
//
//        return $this->success()->send();
//    }
//
//    /**
//     * メールアドレス認証
//     */
//    public function confirmEmail()
//    {
//        $token = $this->request->getQuery("token");
//
//        $reseting = ResetEmails::findFirstByToken($token);
//        if (!$reseting || $reseting->expired_time < date("Y-m-d H:i:s")) {
//            return $this->error(404)->send();
//        }
//
//        $user = $reseting->users;
//        $user->email = $reseting->email;
//
//        if (!$user->update()) {
//            return $this->error(500)->send();
//        }
//        $reseting->delete();
//
//        $isEndUser = $user->role === "USER";
//
//        $query = "?message=メールアドレスの再認証が完了しました。ログインしてください";
//        $targetUrl = $isEndUser
//            ? Utils::getInstance()->getMyHost() . getenv("USER_CONFIRM_EMAIL_PATH") . $query
//            : Utils::getInstance()->getMyHost() . getenv("ADMIN_CONFIRM_EMAIL_PATH") . $query;
//        return $this->response->redirect($targetUrl, true)->send();
//    }
//
//    /**
//     * パスワード更新
//     */
//    public function resetPassword()
//    {
//        $param = $this->getJsonParam();
//
//        $user = \Users::findFirstByEmail($param->email);
//
//        if (!$user) {
//            return $this->error(404)->send();
//        }
//
//        $token = $this->security->getRandom()->base64Safe(250);
//        $expiredTime = date("Y-m-d H-i-:s", strtotime(self::EMAIL_EXPIRED_PERIOD));
//        $expiredTimeToFmt = date("Y年m月d日 H時i分", strtotime(self::EMAIL_EXPIRED_PERIOD));
//
//        $reseting = new ResetPasswords([
//            'user_id' => $user->id,
//            'expired_time' => $expiredTime,
//            'token' => $token
//        ]);
//
//        if (!$reseting->create()) {
//            return $this->error(500)->send();
//        }
//
//        $query = "?token=" . $token;
//        $isEndUser = $user->role === "USER";
//        $targetUrl = $isEndUser
//            ? Utils::getInstance()->getMyHost() . getenv("USER_CONFIRM_PASSWORD_PATH") . $query
//            : Utils::getInstance()->getMyHost() . getenv("ADMIN_CONFIRM_PASSWORD_PATH") . $query;
//
//        if (!SessionService::g()->sendConfirmPassword($param->email, $expiredTimeToFmt, $targetUrl)) {
//            return $this->error(500)->send();
//        }
//
//        return $this->success()->send();
//    }
//
//    /**
//     * パスワード再設定
//     */
//    public function confirmPassword()
//    {
//        $param = $this->getJsonParam();
//
//        $reseting = ResetPasswords::findFirstByToken($param->token);
//
//        if (!$reseting || $reseting->expired_time < date("Y-m-d H:i:s")) {
//            return $this->error(404)->send();
//        }
//
//        $user = $reseting->users;
//        $user->password = $this->security->hash($param->password);
//
//        // バリデーション
//        $validation = new PasswordValidation();
//        $messages = $validation->validate([
//            'password' => $param->password,
//            'username' => $user->email
//        ]);
//
//        if (count($messages)) {
//            $messages = $this->getFormattedMessage($messages);
//            return $this->error("wrong_params", $messages)->send();
//        }
//
//        if (!$user->update()) {
//            return $this->error(500)->send();
//        }
//        $reseting->delete();
//
//        return $this->success()->send();
//    }
//
//
//    /**
//     * パスワード変更
//     */
//    public function changePassword()
//    {
//        $param = $this->getJsonParam();
//
//        $encryptedId = $this->auth['sub'];
//        $user = Users::findFirstByEncryptedId($encryptedId);
//
//        if (!SessionService::g()->isCorrectPassword($user, $param->current_password)) {
//            return $this->error(404, $this->getFormattedMessage([["message" => "パスワードが正しくありません"]]))->send();
//        }
//
//        // バリデーション
//        $validation = new PasswordValidation();
//        $messages = $validation->validate([
//            'password' => $param->new_password,
//            'username' => $user->email
//        ]);
//
//        if (count($messages)) {
//            $messages = $this->getFormattedMessage($messages);
//            return $this->error("wrong_params", $messages)->send();
//        }
//
//        $user->password = $this->security->hash($param->new_password);
//
//        if (!$user->update()) {
//            return $this->error(500)->send();
//        }
//        return $this->success()->send();
//    }
}
