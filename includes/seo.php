<?php
function getSEOMeta($page) {
    $meta = [
        'index' => [
            'title' => 'ContentKrate - Premium Digital Products Marketplace',
            'description' => 'Discover and purchase high-quality digital products for content creators and professionals',
            'keywords' => 'digital products, content creation, marketplace, creative tools'
        ],
        'products' => [
            'title' => 'Products - ContentKrate Marketplace',
            'description' => 'Browse our collection of premium digital products for content creators',
            'keywords' => 'digital products, content tools, creative assets'
        ],
        'product-detail' => [
            'title' => '{{PRODUCT_NAME}} - ContentKrate',
            'description' => '{{PRODUCT_DESCRIPTION}}',
            'keywords' => '{{PRODUCT_KEYWORDS}}'
        ],
        'about' => [
            'title' => 'About ContentKrate - Our Story',
            'description' => 'Learn about ContentKrate and our mission to support content creators',
            'keywords' => 'about us, contentkrate story, digital marketplace'
        ]
    ];
    
    return $meta[$page] ?? [
        'title' => 'ContentKrate',
        'description' => 'Premium digital products marketplace',
        'keywords' => 'digital products, marketplace'
    ];
}
?>