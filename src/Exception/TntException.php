<?php 
namespace TNTma\TronWeb\Exception;


class TntException extends \RuntimeException
{
    protected $error;

    public function __construct($error,$code = 401)
    {
        parent::__construct();
        $this->error = $error;
        $this->code = $code;
        $this->message = is_array($error) ? implode(PHP_EOL, $error) : $error;
    }

    /**
     * @param mixed $code
     * @return TntException
     */
    public function setCode($code): TntException
    {
        $this->code = $code;
        return $this;
    }

    /**
     * 获取验证错误信息
     * @access public
     * @return array|string
     */
    public function getError()
    {
        return $this->error;
    }
}