<?php
declare(strict_types=1);

namespace icePHP\Frame\MVC;
/**
 * 跨页显示消息,通过Session保存
 * @author Ice
 *
 */
class Message
{
    //保存错误消息的SESSION,Key
    const ERROR = 'ICE_MESSAGE_ERROR';

    //保存成功消息的SESSION,Key
    const SUCCESS = 'ICE_MESSAGE_SUCCESS';

    //保存提示消息的SESSION,Key
    const INFORMATION = 'ICE_MESSAGE_INFO';

    //禁止实例化
    private function __construct()
    {
    }

    /**
     * 记录一条错误消息
     * @param string $err
     */
    public static function setError(string $err): void
    {
        foreach(explode("\n",$err) as $msg){
            $_SESSION[self::ERROR][] = $msg;
        }
    }

    /**
     * 记录一条成功消息
     * @param string $msg
     */
    public static function setSuccess(string $msg): void
    {
        $_SESSION[self::SUCCESS][] = $msg;
    }

    /**
     * 记录一条提示消息
     * @param string $info
     */
    public static function setInfo(string $info): void
    {
        $_SESSION[self::INFORMATION][] = $info;
    }

    /**
     * 获取所有错误消息
     * @return array
     */
    public static function getErrors(): array
    {
        //空
        if (!isset($_SESSION[self::ERROR])) {
            return [];
        }

        //用BR拼接
        $ret = $_SESSION[self::ERROR];

        //取出即销毁,下次就没了
        unset($_SESSION[self::ERROR]);
        return $ret;
    }

    /**
     * 取出所有成功的消息
     * @return array
     */
    public static function getSuccesses(): array
    {
        //空
        if (!isset($_SESSION[self::SUCCESS])) {
            return [];
        }

        //结果
        $ret = $_SESSION[self::SUCCESS];

        //销毁
        unset($_SESSION[self::SUCCESS]);
        return $ret;
    }

    /**
     * 取出所有提示消息
     * @return array
     */
    public static function getInfos(): array
    {
        //空
        if (!isset($_SESSION[self::INFORMATION])) {
            return [];
        }

        $ret = $_SESSION[self::INFORMATION];

        //销毁
        unset($_SESSION[self::INFORMATION]);
        return $ret;
    }

    /**
     * 检查是否有消息,任何类型
     * @return boolean
     */
    public static function has(): bool
    {
        return self::hasError() || self::hasInfo() || self::hasSuccess();
    }

    /**
     * 获取所有消息,任何类型
     * @return array
     */
    public static function getAll(): array
    {
        return array_merge(self::getErrors(), self::getInfos(), self::getSuccesses());
    }

    /**
     * 检查有没有错误消息
     * @return boolean
     */
    public static function hasError(): bool
    {
        if (!isset($_SESSION[self::ERROR])) {
            return false;
        }
        return count($_SESSION[self::ERROR]) > 0;
    }

    /**
     * 检查有没有成功消息
     * @return boolean
     */
    public static function hasSuccess(): bool
    {
        if (!isset($_SESSION[self::SUCCESS])) {
            return false;
        }
        return count($_SESSION[self::SUCCESS]) > 0;
    }

    /**
     * 检查有没有提示消息
     * @return boolean
     */
    public static function hasInfo(): bool
    {
        if (!isset($_SESSION[self::INFORMATION])) {
            return false;
        }
        return count($_SESSION[self::INFORMATION]) > 0;
    }

    /**
     * @var array 记录本次表单错误的数据
     */
    private static $formDataOld;

    /**
     * 记录错误表单数据
     * @param array $data
     */
    public static function setFormDataOld(array $data)
    {
        self::$formDataOld = $data;
    }

    /**
     * 获取本次错误表单数据
     * @return array
     */
    public static function getFormDataOld()
    {
        return self::$formDataOld;
    }
}