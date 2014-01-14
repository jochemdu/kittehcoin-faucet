<? 
  require_once 'jsonRPCClient.php';
 
  $bitcoin = new jsonRPCClient('http://kitteh:zomgitworks@151.227.69.160:9192/');
 
echo "<pre>\n";
print_r($bitcoin->getinfo());

print_r($bitcoin->getreceivedbyaddress('KHi1Lf6Hi81yc61r5SKQMvkCMSF5s9JbSY'));
echo "</pre><P>";


$ch = curl_init("https://www.dan.me.uk/torlist/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$text = curl_exec($ch);
$test = strpos($text, "106.186.118.118");
if ($test==false)
{
    echo "no";
}
else
{
    echo "yes";
}
  
?>