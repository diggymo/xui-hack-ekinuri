<?php
/**
 * Created by PhpStorm.
 * User: civiluo-1
 * Date: 2018/04/30
 * Time: 1:35
 */

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

// ACLファイル保存先
const ACL_FILE_PATH = "acl.data";

const GUEST = "GUEST";
const USER = "USER";
const FRANCHISE = "FRANCHISE";
const CORPORATION = "CORPORATION";
const ADMIN = "ADMIN";

// Check whether ACL data already exist
// 開発環境では常に最新
if (getenv("MODE") === "development" || !is_file(ACL_FILE_PATH)) {

    $acl = new AclList();

    // Default action is deny access
    $acl->setDefaultAction(
        Acl::ALLOW
    );

    // 権限を作成
    $acl->addRole(GUEST);
    $acl->addRole(USER, GUEST);
    $acl->addRole(FRANCHISE, USER);
    $acl->addRole(CORPORATION, FRANCHISE);
    $acl->addRole(ADMIN, CORPORATION);

    /**
     * リソースとアクションの設定
     */
    $aclArray = [
        "1" => [
            "QaController" => [
                "search" => USER,
                "create" => ADMIN,
                "update" => ADMIN,
                "delete" => ADMIN
            ],
            "AgenciesController" => [
                "search" => ADMIN,
                "create" => ADMIN,
                "index" => FRANCHISE,
                "update" => ADMIN,
                "delete" => ADMIN
            ],
            "AdvertisementController" => [
                "search" => GUEST,
                "show" => GUEST,
                "create" => ADMIN,
                "update" => ADMIN,
                "delete" => ADMIN,
            ],
            "InformationsController" => [
                "search" => USER,
                "create" => ADMIN,
                "update" => ADMIN,
                "delete" => ADMIN
            ],
            "TestController" => [
                "migration" => GUEST,
                "hoge" => USER,
                "index" => FRANCHISE,
                "get" => GUEST,
                "post" => GUEST,
                "throwError" => GUEST,
                "findFranchise" => GUEST
            ],
            "SessionController" => [
                "login" => GUEST,
                "resetEmail" => USER,
                "confirmEmail" => GUEST,
                "resetPassword" => GUEST,
                "confirmPassword" => GUEST,
                "changePassword" => USER
            ],
            "CustomerController" => [
                "signup" => GUEST,
                "search" => ADMIN,
                "index" => USER,
                "update" => USER,
                "changePaymentMethod" => USER,
                "deleteUser" => USER,
                "notificateBilling" => GUEST,
                "completeBilling" => GUEST,
                "confirmEmail" => GUEST
            ],
            "StationsController" => [
                "search" => GUEST,
            ],
            "MailsController" => [
                "search" => ADMIN,
                "send" => ADMIN,
                "index" => ADMIN,
            ],
            "AnalysisController" => [
                "search" => FRANCHISE,
            ],
            "CorporationsController" => [
                "search" => ADMIN,
                "index" => CORPORATION,
                "create" => ADMIN,
                "update" => ADMIN,
                "delete" => ADMIN,
                "brands" => CORPORATION,
                "createBrand" => CORPORATION,
                "updateBrand" => CORPORATION,
                "deleteBrand" => CORPORATION,
                "user" => ADMIN,
                "saveUser" => ADMIN,
                "deleteUser" => CORPORATION
            ],
            "FranchisesController" => [
                "search" => CORPORATION,
                "index" => GUEST,
                "nearlySearch" => GUEST,
                "bulkSearch" => GUEST,
                "create" => CORPORATION,
                "signup" => GUEST,
                "update" => FRANCHISE,
                "delete" => FRANCHISE,
                "verify" => ADMIN,
                "user" => CORPORATION,
                "saveUser" => CORPORATION,
                "deleteUser" => CORPORATION,
                "confirmEmail" => GUEST,
                "reflect" => GUEST,
                "eventCreate" => FRANCHISE,
                "eventUpdate" => FRANCHISE,
                "eventDelete" => FRANCHISE,
            ],
            "UsageLogsController" => [
                "search" => USER,
                "create" => USER,
                "review" => USER,
            ]
        ]
    ];

    // aclに定義
    foreach ($aclArray as $version => $resouces) {
        $versionPrefix = 'App_Controllers_V' . $version;
        foreach ($resouces as $resouce => $roleInfo) {
            $resouceName = $versionPrefix . "_" . $resouce;
            $acl->addResource($resouceName, array_keys($roleInfo));

            foreach ($roleInfo as $action => $role) {
                $acl->allow($role, $resouceName, $action);
            }
        }
    }

    // シリアライズ化して高速化
    file_put_contents(
        ACL_FILE_PATH,
        serialize($acl));
} else {
    // ファイルから取得
    $acl = unserialize(
        file_get_contents(ACL_FILE_PATH)
    );
}

return $acl;
