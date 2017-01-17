<?php
namespace Ap;
/**
 * Sessionクラス
 */
class Session
{
    protected static $session_started = false;
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        if (!self::$session_started) {
            session_start();
            self::$session_started = true;
        }
    }
    /**
     * セッションIDを取得する
     *
     * @return string セッションID
     */
    public function id()
    {
        return session_id();
    }
    /**
     * セッション変数を設定する
     *
     * @param string $name  変数名
     * @param mixed  $value 値
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    /**
     * セッション変数を取得する
     *
     * @param string $name    変数名
     * @param mixed  $default 取得できなかった場合の初期値
     *
     * @return mixed セッション変数値
     */
    public function get($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $default;
    }
    /**
     * セッション変数を削除する
     *
     * @param string $name 変数名
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }
    /**
     * セッション変数をクリアする
     */
    public function clear()
    {
        $_SESSION = [];
    }
    /**
     * セッションIDを再生成する
     */
    public function regenerate()
    {
        session_regenerate_id(true);
    }
    /**
     * セッションを破棄する
     */
    public function destroy()
    {
        $this->clear();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }
}
