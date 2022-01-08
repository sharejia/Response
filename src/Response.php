<?php

namespace Sharejia\Response;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

use Illuminate\Support\Facades\Response as LaravelResponse;

class Response
{
    /**
     * 响应HTTP状态码
     * @var int
     */
    protected static $statusCode = FoundationResponse::HTTP_OK;

    /**
     * http响应状态码
     * @var int
     */
    protected static $httpCode = FoundationResponse::HTTP_OK;

    /**
     * 请求成功响应
     * @param array $data
     * @param string $message
     * @param int $statusCode
     * @param int $httpCode
     * @param array $headers
     * @return mixed
     */
    public static function success(
        array  $data = [],
        string $message = '请求成功',
        int    $statusCode = FoundationResponse::HTTP_OK,
        int    $httpCode = FoundationResponse::HTTP_OK,
        array  $headers = []
    )
    {
        # 设置code
        self::setStatusCode($statusCode, $httpCode);

        # 响应
        return self::response(
            [
                'code' => self::getStatusCode(),
                'msg'  => $message,
                'data' => $data
            ],
            $headers
        );
    }

    /**
     * 失败响应
     * @param string $message
     * @param int $statusCode
     * @param int $httpCode
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public static function fail(
        string $message = '内部错误',
        int    $statusCode = FoundationResponse::HTTP_INTERNAL_SERVER_ERROR,
        int    $httpCode = FoundationResponse::HTTP_OK,
        array  $data = [],
        array  $headers = []
    )
    {
        # 设置code
        self::setStatusCode($statusCode, $httpCode);

        # 响应
        return self::response(
            [
                'code' => self::getStatusCode(),
                'msg'  => $message,
                'data' => $data
            ],
            $headers
        );
    }

    /**
     * 提示信息
     * @param $message
     * @param int $statusCode
     * @param int $httpCode
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public static function message(
        $message,
        int $statusCode = FoundationResponse::HTTP_OK,
        int $httpCode = FoundationResponse::HTTP_OK,
        array $data = [],
        array $headers = []
    )
    {
        # 设置code
        self::setStatusCode($statusCode, $httpCode);

        # 响应
        return self::response(
            [
                'code' => self::getStatusCode(),
                'msg'  => $message,
                'data' => $data
            ],
            $headers
        );
    }

    /**
     * 最终响应
     * @param $data
     * @param array $header
     * @return mixed
     */
    private static function response($data, array $header = [])
    {
        return LaravelResponse::json($data, self::getHttpCode(), $header);
    }

    /**
     * 返回response code
     * @return int
     */
    public static function getStatusCode(): int
    {
        return self::$statusCode;
    }

    /**
     * 返回response http code
     * @return int
     */
    public static function getHttpCode(): int
    {
        return self::$httpCode;
    }

    /**
     * 设置HTTP状态码
     * @param int $statusCode
     * @param int|null $httpCode
     * @return $this
     */
    public static function setStatusCode(int $statusCode, int $httpCode = FoundationResponse::HTTP_OK): Response
    {
        # 设置http response code
        self::$httpCode = $httpCode;

        # 设置response status code
        self::$statusCode = $statusCode;

        return new self();
    }

}
