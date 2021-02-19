mod.wizards.newContentElement.wizardItems.common {
    elements {
            accordion {
                iconIdentifier = tx_accordion_accordion
                title = LLL:EXT:accordion/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.accordion_title
                description = LLL:EXT:accordion/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.accordion_description
                tt_content_defValues {
                    CType = accordion_accordion
                }
            }
    }
    show := addToList(accordion)
}
