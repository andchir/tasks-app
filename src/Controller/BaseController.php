<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;

class BaseController {

    /** @var array */
    protected $config;
    /** @var EntityManager */
    protected $entityManager;

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
}
