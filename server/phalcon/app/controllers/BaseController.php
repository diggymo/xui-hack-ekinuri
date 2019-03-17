<?php

namespace App\Controllers;


use App\Lib\Utils;
use Phalcon\Mvc\Controller;
use Yosymfony\Toml\Toml;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    // 正常に処理が終了した場合のHTTPステータスコード
    const SUCCESS_HTTP_STATUS_CODE = [
        'GET' => 200,
        'POST' => 201,
        'PUT' => 204,
        'PATCH' => 204,
        'DELETE' => 204
    ];

    const TOKEN_HEADER = "X-Hoge-Token";
    const TOKEN_EXPIRES_AT_HEADER = "X-Hoge-Token-Expires-At";
    const REFRESH_TOKEN_HEADER = "X-Hoge-Refresh-Token";
    const VERSION_HEADER = "Version";

    protected $version = "";

    /**
     * エラー時の返却
     * @param string $type
     * @param array $content
     * @return \Phalcon\Http\Response
     */
    public function error($type = "404", $content = [])
    {
        $message = $this->getMessage($type);
        return $this->response->setHeader(self::VERSION_HEADER, $this->version)
            ->setStatusCode($message['status'], $message['message'])
            ->setJsonContent($content)
            ->sendHeaders();
    }

    /**
     * 正常処理の場合の返却
     * @param $body
     * @return \Phalcon\Http\Response
     */
    public function success($body = [])
    {
        return $this->response->setHeader(self::VERSION_HEADER, $this->version)
            ->setStatusCode($this->getSuccessCode(), null)
            ->setJsonContent($body)
            ->setHeader(self::VERSION_HEADER, $this->version);
    }

    /**
     * HTTPメソッドに応じて、適切な2xxコードを返却する
     *
     * @return integer
     */
    private function getSuccessCode()
    {
        return $this::SUCCESS_HTTP_STATUS_CODE[$this->request->getMethod()];
    }

    /**
     * メッセージを送信するためにtomlをパース
     * TODO diに登録しなくてもいいか？
     * @param string $type
     * @return array
     */
    private function getMessage($type)
    {
        $array = Toml::ParseFile(APP_PATH . '/config/message.toml');
        return $array[$type] ?: [];
    }

    /**
     * jsonから値を取得する
     * @return array|bool|\stdClass
     */
    protected function getJsonParam()
    {
        return $this->request->getJsonRawBody(false);
    }

    /**
     * 画面に表示するためにフォーマット
     * @param array $messagesArray
     * @return array
     */
    protected function getFormattedMessage(...$messagesArray)
    {
        $formattedMessages = [];
        foreach ($messagesArray as $messages) {
            foreach ($messages as $message) {

                // 連想配列の場合
                if (is_array($message)) {
                    $formattedMessages[] = [
                        'field' => $message['field'],
                        'message' => $message['message']
                    ];
                    continue;
                }

                // Messageの場合
                $formattedMessages[] = [
                    'field' => $message->getField(),
                    'message' => $message->getMessage()
                ];
            }
        }

        return $formattedMessages;
    }
}