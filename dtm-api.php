<?php
header('Content-Type: application/json; charset=utf-8');

function user_search($userid) {
    $url = "https://mandat.uzbmb.uz/Bakalavr2024/MainSearch";
    $headers = [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
        "accept-language: uz,ru-RU;q=0.9,ru;q=0.8,en-US;q=0.7,en;q=0.6",
        "cache-control: max-age=0",
        "content-type: application/x-www-form-urlencoded",
        "cookie: .AspNetCore.Antiforgery.UZ8z2jIqXdQ=CfDJ8KT4Bo0BTQxKkda2RU6eBFvtYiSZFOnFi5tWYKLyjjPalsAIp1kzyIVv3dK2qrRo-fnuKjxJDZFDu-yln2HUp3vpAOQ4xtTo__pVGOr99JBmJwVyiOhToGAV64wvrN25O7DvbhylHxWFnecNPUI3Dcs",
        "origin: https://mandat.uzbmb.uz",
        "priority: u=0, i",
        "referer: https://mandat.uzbmb.uz/Bakalavr2024/MainSearch",
        "sec-ch-ua: \"Not/A)Brand\";v=\"8\", \"Chromium\";v=\"126\", \"Google Chrome\";v=\"126\"",
        "sec-ch-ua-mobile: ?1",
        "sec-ch-ua-platform: \"Android\"",
        "sec-fetch-dest: document",
        "sec-fetch-mode: navigate",
        "sec-fetch-site: same-origin",
        "sec-fetch-user: ?1",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36"
    ];

    $data = [
        "entrantid" => $userid,
        "lang" => "uz",
        "__RequestVerificationToken" => "CfDJ8KT4Bo0BTQxKkda2RU6eBFuHIt4iTDGsfGj_wBRfXHb7AYkjYK6uz9_HRHg9QOC5q75MlNLooz4PEauoahpT6LPt6shvrkD3YbJA6vbzWBGpjQLcGPR1iT5Cr1hbiDnGthjI7i4QSVifGtEa_Zf1ygw"
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    $dom = new DOMDocument();
    @$dom->loadHTML($response);
    $xpath = new DOMXPath($dom);
    $trs = $xpath->query('//tr');

    if ($trs->length == 0) {
        return false;
    }

    foreach ($trs as $tr) {
        $tds = $tr->getElementsByTagName('td');
        if ($tds->length > 0) {
            if ($tds->item(0)->textContent == $userid) {
                return [
                    "user_id" => $tds->item(0)->textContent,
                    "full_name" => $tds->item(1)->textContent,
                    "user_ball" => $tds->item(2)->textContent,
                    "get_info" => "https://mandat.uzbmb.uz" . $tds->item(3)->getElementsByTagName('a')->item(0)->getAttribute('href')
                ];
            }
        }
    }

    return false;
}


echo json_encode(user_search("5466717"));

?>
