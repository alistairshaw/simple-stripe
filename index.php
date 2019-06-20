<?php require __DIR__ . '/vendor/autoload.php';

use Stripe\Checkout\Session;
use Stripe\Stripe;

// customise this stuff
$stripePrivateKey = '';
$stripePublicKey = '';
$amount = 19900;
$productName = 'Translation Services';
$productDescription = 'These are the days of our lives.';
$logo = 'https://translatoruk.co.uk/imgx/translator-uk-official-logo.png';
$successUrl = 'https://google.com';
$cancelUrl = 'https://yahoo.com';

Stripe::setApiKey($stripePrivateKey);

$session = Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'name' => $productName,
        'description' => $productDescription,
        'images' => [$logo],
        'amount' => $amount,
        'currency' => 'eur',
        'quantity' => 1,
    ]],
    'success_url' => $successUrl,
    'cancel_url' => $cancelUrl,
]);

?>

<html>
    <head>
        <title>Make a payment!</title>
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        <div id="error"></div>
        <script>
            var stripe = Stripe('<?= $stripePublicKey ?>');
            stripe.redirectToCheckout({
                sessionId: '<?= $session->id ?>'
            }).then(function (result) {
                document.getElementById('error').innerHTML(result);
            });
        </script>
    </body>
</html>
