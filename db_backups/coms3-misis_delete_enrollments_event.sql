CREATE EVENT IF NOT EXISTS delete_old_enrollments ON SCHEDULE EVERY 1 DAY ENABLE
COMMENT 'Delete enrollments from table when expiry date is reached'
  DO 
  DELETE FROM `coms3-misis`.`enrollments`
  WHERE `expiryDate` < NOW();