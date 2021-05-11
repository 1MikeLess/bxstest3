<?

ob_start();
echo file_get_contents('mail_template.php');
$mailHtml = ob_get_contents();
ob_end_clean();

echo $mailHtml;
