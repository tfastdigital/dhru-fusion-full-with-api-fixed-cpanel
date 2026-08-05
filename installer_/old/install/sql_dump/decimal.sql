ALTER TABLE `tbl_services_imei` CHANGE `credit` `credit` DECIMAL( 12, 2 ) NULL DEFAULT NULL ;
ALTER TABLE `tbl_services_imei` CHANGE `retail_credit` `retail_credit` DECIMAL( 15, 2 ) NULL DEFAULT NULL ;
ALTER TABLE `tbl_services_file` CHANGE `credit` `credit` DECIMAL( 12, 2 ) NULL DEFAULT NULL ;
ALTER TABLE `tbl_server_log` CHANGE `credit` `credit` DECIMAL( 12, 2 ) NULL DEFAULT NULL ;
ALTER TABLE `tbl_products` CHANGE `credit` `credit` DECIMAL( 12, 2 ) NOT NULL ;
ALTER TABLE `tbl_services_imei` CHANGE `prev_price` `prev_price` DECIMAL( 20, 2 ) NULL DEFAULT NULL ;
ALTER TABLE `tbl_customgatewayprice` CHANGE `credit` `credit` DECIMAL( 25, 2 ) NOT NULL ;
ALTER TABLE `tbl_wholesaleprice` CHANGE `credit` `credit` DECIMAL( 25, 2 ) NOT NULL ;