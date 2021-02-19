tt_content.accordion_accordion = FLUIDTEMPLATE
tt_content.accordion_accordion {
    layoutRootPaths.0 = EXT:accordion/Resources/Private/Layouts/
    layoutRootPaths.10 = {$plugin.tx_accordion.view.layoutRootPath}
    partialRootPaths.0 = EXT:accordion/Resources/Private/Partials/
    partialRootPaths.10 = {$plugin.tx_accordion.view.partialRootPath}
    templateRootPaths.0 = EXT:accordion/Resources/Private/Templates/Content/
    templateRootPaths.10 = {$plugin.tx_accordion.view.templateRootPath}
    templateName = Accordion
    dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.10 {
        if.isTrue.field = tx_accordion_elements
        table = tx_accordion_elements
        pidInList.field = pid
        where = parentid=###uid### AND deleted=0 AND hidden=0
        orderBy = sorting
        markers.uid.field = uid
        as = data_tx_accordion_elements
    }
    dataProcessing.20 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.20 {
        if.isTrue.field = collapsefirst
        fieldName = collapsefirst
        as = collapsefirst
    }
    dataProcessing.30 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.30 {
        if.isTrue.field = hideteaser
        fieldName = hideteaser
        as = hideteaser
    }
    dataProcessing.40 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.40 {
        if.isTrue.field = hideicon
        fieldName = hideicon
        as = hideicon
    }

    dataProcessing.40 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.40 {
        if.isTrue.field = showsearch
        fieldName = showsearch
        as = showsearch
    }

    dataProcessing.50 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
    dataProcessing.50 {
        if.isTrue.field = searchplaceholder
        fieldName = searchplaceholder
        as = searchplaceholder
    }


dataProcessing.10 {
        dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
    dataProcessing.10 {
        if.isTrue.field = tx_accordion_media
        references {
            fieldName = tx_accordion_media
            table = tx_accordion_elements
        }
        as = data_tx_accordion_media
    }

}
}
