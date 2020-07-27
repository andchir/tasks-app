<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use HTMLPurifier;
use HTMLPurifier_Config;

class BaseController {

    const MESSAGE_TYPE_DANGER = 'danger';
    const MESSAGE_TYPE_SUCCESS = 'success';
    const MESSAGE_TYPE_INFO = 'info';

    /** @var array */
    protected $config;
    /** @var EntityManager */
    protected $entityManager;
    /** @var string */
    protected $message = '';
    /** @var string */
    protected $messageType = '';

    /**
     * BaseController constructor.
     * @param array $config
     * @param EntityManager $entityManager
     */
    public function __construct(array $config, EntityManager $entityManager) {
        $this->config = $config;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $message
     * @param string $messageType
     */
    public function setMessage(string $message, string $messageType = self::MESSAGE_TYPE_DANGER): void
    {
        $this->message = $message;
        $this->messageType = $messageType;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getMessageType(): string
    {
        return $this->messageType;
    }

    /**
     * @return bool
     */
    public function getIsError(): bool
    {
        return !empty($this->message) && $this->messageType === self::MESSAGE_TYPE_DANGER;
    }

    /**
     * @param string $templateName
     * @return string
     */
    public function getTemplatePath(string $templateName): string
    {
        $templatePath = $this->config['rootPath'] . $this->config['templatesDirPath'];
        $templatePath .= DIRECTORY_SEPARATOR . $templateName . '.html.php';
        return file_exists($templatePath) ? $templatePath : '';
    }

    /**
     * Get HTML code of the page
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function getPage(string $templateName, array $data = []): string
    {
        $templatePath = $this->getTemplatePath($templateName);
        if (!$templatePath) {
            return '';
        }

        $config = $this->config;

        ob_start();
        include $templatePath;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * Get user data
     * @return array|null
     */
    public static function getUser()
    {
        $user = self::sessionGet('user');
        return !empty($user['id']) ? $user : null;
    }

    /**
     * Get pages data by request
     * @param $totalItems
     * @param int $perPage
     * @param string $orderBy
     * @return array
     */
    public static function getPagesData($totalItems, $perPage = 12, $orderBy = 'id'): array
    {
        $pages = array(
            'current' => 1,
            'total' => 0,
            'perPage' => $perPage,
            'offset' => 0,
            'orderBy' => $orderBy
        );
        $pages['current'] = !empty($_GET['page']) && is_numeric($_GET['page'])
            ? $_GET['page']
            : 1;
        $pages['total'] = ceil($totalItems / $pages['perPage']);
        $pages['offset'] = $pages['perPage'] * ($pages['current'] - 1);

        return $pages;
    }

    /**
     * Clean string
     * @param string $string
     * @param bool $isHTMLAllowed
     * @return string
     */
    public static function cleanString(string $string, $isHTMLAllowed = false): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        if ($isHTMLAllowed) {
            $config->set('HTML.Allowed', 'p,b,a[href],i');
        } else {
            $config->set('HTML.Allowed', '');
        }
        return $purifier->purify($string);
    }

    /**
     * @param string $redirectUrl
     * @param bool $permanent
     */
    public static function redirectTo(string $redirectUrl, bool $permanent = false): void
    {
        $hostUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        if (strpos($redirectUrl, $hostUrl) === false) {
            $redirectUrl = $hostUrl . $redirectUrl;
        }
        header('Location: ' . $redirectUrl, true, $permanent ? 301 : 302);
        exit;
    }

    /**
     * @param string $name
     * @return array|null
     */
    static function sessionGet(string $name)
    {
        return !empty($_SESSION[$name])
            ? $_SESSION[$name]
            : null;
    }

    /**
     * @param string $name
     * @param mixed $data
     */
    static function sessionSet(string $name, $data): void
    {
        $_SESSION[$name] = $data;
    }

    /**
     * @param string $name
     */
    static function sessionDelete(string $name): void
    {
        $_SESSION[$name] = null;
        unset($_SESSION[$name]);
    }
}
