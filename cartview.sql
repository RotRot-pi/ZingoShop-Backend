old:


CREATE OR REPLACE VIEW cartview AS select `e_commerce`.`items`.`items_price` * `e_commerce`.`cart`.`cart_item_count` AS `total_price`,`e_commerce`.`cart`.`cart_id` AS `cart_id`,`e_commerce`.`cart`.`cart_user_id` AS `cart_user_id`,`e_commerce`.`cart`.`cart_item_id` AS `cart_item_id`,`e_commerce`.`cart`.`cart_item_count` AS `cart_item_count`,`e_commerce`.`items`.`items_id` AS `items_id`,`e_commerce`.`items`.`items_name` AS `items_name`,`e_commerce`.`items`.`items_name_ar` AS `items_name_ar`,`e_commerce`.`items`.`items_price` AS `items_price`,`e_commerce`.`items`.`items_discount` AS `items_discount`,`e_commerce`.`items`.`items_active` AS `items_active`,`e_commerce`.`items`.`items_count` AS `items_count`,`e_commerce`.`items`.`items_image` AS `items_image`,`e_commerce`.`items`.`items_description` AS `items_description`,`e_commerce`.`items`.`items_description_ar` AS `items_description_ar`,`e_commerce`.`items`.`items_datetime` AS `items_datetime`,`e_commerce`.`items`.`items_category` AS `items_category` from (`e_commerce`.`cart` join `e_commerce`.`items` on(`e_commerce`.`items`.`items_id` = `e_commerce`.`cart`.`cart_item_id`)) group by `e_commerce`.`cart`.`cart_item_id`,`e_commerce`.`cart`.`cart_user_id`;

new:

CREATE OR REPLACE VIEW cartview AS
SELECT
    (`e_commerce`.`items`.`items_price` - `e_commerce`.`items`.`items_price` * `e_commerce`.`items`.`items_discount` / 100) * `e_commerce`.`cart`.`cart_item_count` AS `total_price`,
    `e_commerce`.`cart`.`cart_id` AS `cart_id`,
    `e_commerce`.`cart`.`cart_user_id` AS `cart_user_id`,
    `e_commerce`.`cart`.`cart_item_id` AS `cart_item_id`,
    `e_commerce`.`cart`.`cart_item_count` AS `cart_item_count`,
    `e_commerce`.`items`.`items_id` AS `items_id`,
    `e_commerce`.`items`.`items_name` AS `items_name`,
    `e_commerce`.`items`.`items_name_ar` AS `items_name_ar`,
    (`e_commerce`.`items`.`items_price` - `e_commerce`.`items`.`items_price` * `e_commerce`.`items`.`items_discount` / 100) AS `items_price`,
    `e_commerce`.`items`.`items_discount` AS `items_discount`,
    `e_commerce`.`items`.`items_active` AS `items_active`,
    `e_commerce`.`items`.`items_count` AS `items_count`,
    `e_commerce`.`items`.`items_image` AS `items_image`,
    `e_commerce`.`items`.`items_description` AS `items_description`,
    `e_commerce`.`items`.`items_description_ar` AS `items_description_ar`,
    `e_commerce`.`items`.`items_datetime` AS `items_datetime`,
    `e_commerce`.`items`.`items_category` AS `items_category`
FROM
    (`e_commerce`.`cart` JOIN `e_commerce`.`items` ON(`e_commerce`.`items`.`items_id` = `e_commerce`.`cart`.`cart_item_id`))
WHERE `e_commerce`.`cart`.`cart_order_id` = 0
GROUP BY
    `e_commerce`.`cart`.`cart_item_id`,
    `e_commerce`.`cart`.`cart_user_id`,
    `e_commerce`.`cart`.`cart_order_id`;
-- ================================================================================================= 
CREATE OR REPLACE VIEW cartview_with_discount2 AS
SELECT 
    (items.items_price - items.items_price * items.items_discount / 100) * cart.cart_item_count AS total_price,
    cart.cart_id,
    cart.cart_user_id,
    cart.cart_item_id,
    cart.cart_item_count,
    items.items_id,
    items.items_name,
    items.items_name_ar,
    (items.items_price - items.items_price * items.items_discount / 100) AS items_price,
    items.items_discount,
    items.items_active,
    items.items_count,
    items.items_image,
    items.items_description,
    items.items_description_ar,
    items.items_datetime,
    items.items_category
FROM 
    cart
INNER JOIN 
    items 
ON 
    items.items_id = cart.cart_item_id
WHERE 
    cart.cart_order_id != 0
GROUP BY 
    cart.cart_item_id;
