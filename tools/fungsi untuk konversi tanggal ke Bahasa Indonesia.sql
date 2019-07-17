USE `ekinerja`;
DROP function IF EXISTS `sf_formatTanggal`;

DELIMITER $$
USE `ekinerja`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `sf_formatTanggal`(tanggal DATE) 
RETURNS varchar(255)
BEGIN
DECLARE varhasil varchar(255);
SELECT CONCAT(
     DAY(tanggal),' ',
    CASE MONTH(tanggal) 
      WHEN 1 THEN 'Januari' 
      WHEN 2 THEN 'Februari' 
      WHEN 3 THEN 'Maret' 
      WHEN 4 THEN 'April' 
      WHEN 5 THEN 'Mei' 
      WHEN 6 THEN 'Juni' 
      WHEN 7 THEN 'Juli' 
      WHEN 8 THEN 'Agustus' 
      WHEN 9 THEN 'September'
      WHEN 10 THEN 'Oktober' 
      WHEN 11 THEN 'November' 
      WHEN 12 THEN 'Desember' 
    END,' ',
    YEAR(tanggal)
  ) INTO varhasil;
  RETURN varhasil;
END$$

DELIMITER ;

