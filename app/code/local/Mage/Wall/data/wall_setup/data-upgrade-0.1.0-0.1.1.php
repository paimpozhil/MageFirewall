<?php
$tickets = Mage::getModel('firewall_rules')
                ->getCollection();
$tickets = array(
    array(
        'title' => 'Broken cart',
        'content_heading' => 'Unable to add items to cart.',
    ),
    array(
        'title' => 'Login issues',
        'content_heading' => 'Cannot login when using IE.',
    ),
);

foreach ($tickets as $ticket) {
    Mage::getModel('wall/firewall_rules')
        ->setData($ticket)
        ->save();
}
print_r($tickets);
