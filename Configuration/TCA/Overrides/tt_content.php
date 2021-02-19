<?php
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['accordion_accordion'] = 'tx_accordion_accordion';
$tempColumns = array (
  'tx_accordion_elements' => 
  array (
    'config' => 
    array (
      'appearance' =>
      array (
        'collapseAll' => '1',
        'enabledControls' => 
        array (
          'dragdrop' => '1',
        ),
        'levelLinksPosition' => 'top',
      ),
      'foreign_field' => 'parentid',
      'foreign_sortby' => 'sorting',
      'foreign_table' => 'tx_accordion_elements',
      'foreign_table_field' => 'parenttable',
      'type' => 'inline',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:accordion/Resources/Private/Language/locallang_db.xlf:tt_content.tx_accordion_elements',
  ),
    'collapsefirst' => array(
        'exclude' => 0,
        'label' => 'Erstes Element ausklappen',
        'config' => array(
            'type' => 'check'
        )
    ),
    'hideteaser' => array(
        'exclude' => 0,
        'label' => 'Teaser ausblenden',
        'config' => array(
            'type' => 'check'
        )
    ),
    'hideicon' => array(
        'exclude' => 0,
        'label' => 'Icons ausblenden',
        'config' => array(
            'type' => 'check'
        )
    ),
    'showsearch' => array(
        'exclude' => 0,
        'label' => 'Show a Searchbar',
        'config' => array(
            'type' => 'check'
        )
    ),

    'searchplaceholder' => array(
        'exclude' => 0,
        'label' => 'Placeholder for the Searchbar',
        'config' => array(
            'type' => 'input'
        )
    ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:accordion/Resources/Private/Language/locallang_db.xlf:tt_content.CType.div._accordion_',
    '--div--',
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:accordion/Resources/Private/Language/locallang_db.xlf:tt_content.CType.accordion_accordion',
    'accordion_accordion',
    'tx_accordion_accordion',
];
$tempTypes = array (
  'accordion_accordion' => 
  array (
    'columnsOverrides' => 
    array (
      'bodytext' => 
      array (
        'config' => 
        array (
          'richtextConfiguration' => 'default',
          'enableRichtext' => 1,
        ),
      ),
    ),

    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,header,header_layout,collapsefirst,hideteaser,hideicon,showsearch,searchplaceholder,bodytext,tx_accordion_elements,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended',
  ),
);
$GLOBALS['TCA']['tt_content']['types'] += $tempTypes;
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'accordion',
    'Configuration/TypoScript/',
    'accordion'
);
