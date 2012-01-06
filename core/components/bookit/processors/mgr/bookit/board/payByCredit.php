<?php
ChromePhp::warn ("payByCredit action");
ChromePhp::warn ($scriptProperties);

$book = $modx->getObject ("Books", $scriptProperties["id"]);

$userProfile = $modx->getObject("modUser", $book->get("idUser"))->getOne("Profile");

$extendedFields = $userProfile->get("extended");
$credit = $extendedFields["credit"];

$day = date("N", $book->get("bookDate"));

$item = $modx->getObject("BookItems", $book->get("idItem"));

$pricing = $modx->getObject("PricingListItem",array(
		"pricing_list" => $item->get("pricing"),
		"priceDay" => $day,
		"priceFrom:<=" => $book->get("bookFrom").":00:00",
		"priceTo:>" => $book->get("bookFrom").":00:00"
		));

$price = $pricing->get('price');

if($credit < $price){
	return $modx->error->failure();
}

$extendedFields["credit"] -= $price;

$userProfile->set('extended', $extendedFields);
$userProfile->save();

$book->set("paid", 1);
$book->save();

return $modx->error->success('');