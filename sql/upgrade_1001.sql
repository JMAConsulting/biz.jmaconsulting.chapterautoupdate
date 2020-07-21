CREATE TABLE `civicrm_ch_auto_update` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique ChAutoUpdate ID',
     `contact_id` int unsigned    COMMENT 'FK to Contact'
,
        PRIMARY KEY (`id`)


,          CONSTRAINT FK_civicrm_ch_auto_update_contact_id FOREIGN KEY (`contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE
)    ;

