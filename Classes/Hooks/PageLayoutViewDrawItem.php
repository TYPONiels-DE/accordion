<?php

namespace TN\Accordion\Hooks;

use TYPO3\CMS\Backend\Form\Exception;
use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageLayoutViewDrawItem implements PageLayoutViewDrawItemHookInterface
{
    /**
     * @var array<string,string>
     */
    protected $supportedContentTypes = array (
    'accordion_accordion' => 'Accordion',
    );

    /**
     * @var StandaloneView|mixed
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $view;

    public function __construct(StandaloneView $view = null)
    {
        $this->view = $view ?: GeneralUtility::makeInstance(StandaloneView::class);
    }

    /**
     * Preprocesses the preview rendering of a content element.
     *
     * @param PageLayoutView $parentObject
     * @param bool $drawItem
     * @param string $headerContent
     * @param string $itemContent
     * @param array<string> $row
     * @return void
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        if (!isset($this->supportedContentTypes[$row['CType']])) {
            return;
        }

        $formDataGroup = GeneralUtility::makeInstance(TcaDatabaseRecord::class);
        $formDataCompiler = GeneralUtility::makeInstance(FormDataCompiler::class, $formDataGroup);
        $formDataCompilerInput = [
            'command' => 'edit',
            'tableName' => 'tt_content',
            'vanillaUid' => (int)$row['uid'],
        ];
        try {
            /** @phpstan-ignore-next-line */
            $result = $formDataCompiler->compile($formDataCompilerInput);
            $processedRow = $this->getProcessedData($result['databaseRow'], $result['processedTca']['columns']);

            if (!isset($this->view) && $this->view !== null) {
                $this->view = GeneralUtility::makeInstance(StandaloneView::class);
            }

            $this->configureView($result['pageTsConfig'], $row['CType']);
            $this->view->assignMultiple(
                [
                    'row' => $row,
                    'processedRow' => $processedRow,
                ]
            );
            $itemContent = $this->view->render();
        } catch (Exception $exception) {
            $message = $GLOBALS['BE_USER']->errorMsg;
            if (empty($message)) {
                $message = $exception->getMessage() . ' ' . $exception->getCode();
            }

            $itemContent = $message;
        }

        $drawItem = false;
    }

    /**
     * @param array<mixed> $pageTsConfig
     * @param string $contentType
     * @return void
     *
     */
    protected function configureView(array $pageTsConfig, $contentType)
    {
        if (empty($pageTsConfig['mod.']['web_layout.']['tt_content.']['preview.'])) {
            return;
        }

        $previewConfiguration = $pageTsConfig['mod.']['web_layout.']['tt_content.']['preview.'];
        list($extensionKey) = explode('_', $contentType, 2);
        $extensionKey .= '.';
        if (!empty($previewConfiguration[$contentType])) {
            $templatePath = GeneralUtility::getFileAbsFileName($previewConfiguration[$contentType]);
            $this->view->setTemplatePathAndFilename($templatePath);
        } else {

            if (!isset($this->view) && $this->view == null) {
                $this->view = GeneralUtility::makeInstance(StandaloneView::class);
            }

            if (!empty($previewConfiguration[$extensionKey]['templateRootPath'])) {
                $this->view->setTemplateRootPaths([
                    'EXT:accordion/Resources/Private/Backend/Templates/Content/',
                    $previewConfiguration[$extensionKey]['templateRootPath'],
                ]);
            }
            if (!empty($previewConfiguration[$extensionKey]['layoutRootPath'])) {
                $this->view->setLayoutRootPaths([
                    'EXT:accordion/Resources/Private/Backend/Layout/',
                    $previewConfiguration[$extensionKey]['layoutRootPath'],
                ]);
            }
            if (!empty($previewConfiguration[$extensionKey]['partialRootPath'])) {
                $this->view->setPartialRootPaths([
                    'EXT:accordion/Resources/Private/Backend/Partials/',
                    $previewConfiguration[$extensionKey]['partialRootPath'],
                ]);
            }
            $this->view->setTemplate($this->supportedContentTypes[$contentType]);
        }
    }

    /**
     * @param array<mixed> $databaseRow
     * @param array<mixed> $processedTcaColumns
     * @return array<mixed>
     */
    protected function getProcessedData(array $databaseRow, array $processedTcaColumns)
    {
        $processedRow = $databaseRow;
        foreach ($processedTcaColumns as $field => $config) {
            if (!isset($config['children'])) {
                continue;
            }
            $processedRow[$field] = [];
            foreach ($config['children'] as $child) {
                if (!$child['isInlineChildExpanded']) {
                    $formDataGroup = GeneralUtility::makeInstance(TcaDatabaseRecord::class);
                    /* @var FormDataCompiler $formDataCompiler */
                    $formDataCompiler = GeneralUtility::makeInstance(FormDataCompiler::class, $formDataGroup);
                    $formDataCompilerInput = [
                        'command' => 'edit',
                        'tableName' => $child['tableName'],
                        'vanillaUid' => $child['vanillaUid'],
                    ];
                    /** @phpstan-ignore-next-line */
                    $child = $formDataCompiler->compile($formDataCompilerInput);
                }
                $processedRow[$field][] = $this->getProcessedData($child['databaseRow'], $child['processedTca']['columns']);
            }
        }

        return $processedRow;
    }
}
