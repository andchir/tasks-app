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
}
