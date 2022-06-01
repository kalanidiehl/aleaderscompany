<?php

/**
 * @file
 * Default rules.
 */

/**
 * Implements hook_default_rules_configuration().
 */
function opigno_commerce_app_default_rules_configuration() {
  $items = array();
  $items['rules_line_item_is_an_og_product'] = entity_import('rules_config', '{ "rules_line_item_is_an_og_product" : {
    "LABEL" : "Line item is an OG product",
    "PLUGIN" : "and",
    "OWNER" : "rules",
    "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
    "REQUIRES" : [ "rules", "commerce" ],
    "USES VARIABLES" : { "commerce_line_item" : { "label" : "Commerce lineiItem", "type" : "commerce_line_item" } },
    "AND" : [
      { "entity_has_field" : { "entity" : [ "commerce-line-item" ], "field" : "commerce_product" } },
      { "entity_is_of_bundle" : {
          "entity" : [ "commerce-line-item:commerce-product" ],
          "type" : "commerce_product",
          "bundle" : { "value" : { "og_product" : "og_product" } }
        }
      },
      { "entity_exists" : {
          "type" : "node",
          "property" : "opigno_commerce_product",
          "value" : [ "commerce-line-item:commerce-product:product-id" ]
        }
      }
    ]
  }
}');
  $items['rules_fetch_og_product_price'] = entity_import('rules_config', '{ "rules_fetch_og_product_price" : {
    "LABEL" : "Fetch OG product price",
    "PLUGIN" : "action set",
    "OWNER" : "rules",
    "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
    "REQUIRES" : [ "rules", "rules_conditional" ],
    "USES VARIABLES" : {
      "commerce_line_item" : { "label" : "Commerce line item", "type" : "commerce_line_item" },
      "price" : { "label" : "Price", "type" : "commerce_price", "parameter" : false }
    },
    "ACTION SET" : [
      { "data_set" : {
          "data" : [ "price" ],
          "value" : { "value" : { "amount" : 0, "currency_code" : "USD" } }
        }
      },
      { "component_rules_fetch_og_from_line_item" : {
          "USING" : { "commerce_line_item" : [ "commerce-line-item" ] },
          "PROVIDE" : { "og_node" : { "og_node" : "OG Node" } }
        }
      },
      { "CONDITIONAL" : [
          {
            "IF" : { "entity_has_field" : { "entity" : [ "og-node" ], "field" : "opigno_commerce_price" } },
            "DO" : [
              { "CONDITIONAL" : [
                  {
                    "IF" : { "NOT data_is_empty" : { "data" : [ "og-node:opigno-commerce-price" ] } },
                    "DO" : [
                      { "data_set" : { "data" : [ "price" ], "value" : [ "og-node:opigno-commerce-price" ] } }
                    ]
                  },
                  { "ELSE" : [
                      { "data_set" : {
                          "data" : [ "price" ],
                          "value" : { "value" : { "amount" : 0, "currency_code" : "USD" } }
                        }
                      }
                    ]
                  }
                ]
              }
            ]
          }
        ]
      }
    ],
    "PROVIDES VARIABLES" : [ "price" ]
  }
}');
  $items['rules_fetch_og_from_line_item'] = entity_import('rules_config', '{ "rules_fetch_og_from_line_item" : {
      "LABEL" : "Fetch OG from line item",
      "PLUGIN" : "action set",
      "OWNER" : "rules",
      "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
      "REQUIRES" : [ "rules_conditional", "rules" ],
      "USES VARIABLES" : {
        "commerce_line_item" : { "label" : "Commerce line item", "type" : "commerce_line_item" },
        "og_node" : { "label" : "OG Node", "type" : "node", "parameter" : false }
      },
      "ACTION SET" : [
        { "CONDITIONAL" : [
            {
              "IF" : { "entity_has_field" : { "entity" : [ "commerce-line-item" ], "field" : "commerce_product" } },
              "DO" : [
                { "entity_query" : {
                    "USING" : {
                      "type" : "node",
                      "property" : "opigno_commerce_product",
                      "value" : [ "commerce-line-item:commerce-product" ],
                      "limit" : "1"
                    },
                    "PROVIDE" : { "entity_fetched" : { "node" : "Node" } }
                  }
                },
                { "data_set" : { "data" : [ "og-node" ], "value" : [ "node:0" ] } }
              ]
            }
          ]
        }
      ],
      "PROVIDES VARIABLES" : [ "og_node" ]
    }
  }');
  $items['rules_activate_bought_og_membership'] = entity_import('rules_config', '{ "rules_activate_bought_og_membership" : {
    "LABEL" : "Activate bought OG membership",
    "PLUGIN" : "action set",
    "OWNER" : "rules",
    "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
    "REQUIRES" : [ "rules", "og" ],
    "USES VARIABLES" : {
      "commerce_line_item" : { "label" : "Commerce line item", "type" : "commerce_line_item" },
      "order_owner" : { "label" : "Order owner", "type" : "user" }
    },
    "ACTION SET" : [
      { "component_rules_fetch_og_from_line_item" : {
        "USING" : { "commerce_line_item" : [ "commerce-line-item" ] },
          "PROVIDE" : { "og_node" : { "og_node" : "OG Node" } }
        }
      },
      { "og_subcribe_user" : { "user" : [ "order-owner" ], "group" : [ "og-node" ] } },
      { "og_grant_og_role" : {
        "account" : [ "order-owner" ],
          "group" : [ "og-node" ],
          "roles" : { "value" : { "student" : "student" } }
        }
      }
    ]
  }
}');

  $items['rules_create_og_product_for_course'] = entity_import('rules_config', '{ "rules_create_og_product_for_course" : {
      "LABEL" : "Create OG Product for course",
      "PLUGIN" : "reaction rule",
      "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
      "REQUIRES" : [ "rules" ],
      "ON" : [ "node_view" ],
      "IF" : [
        { "entity_has_field" : { "entity" : [ "node" ], "field" : "opigno_commerce_product" } }
      ],
      "DO" : [
        { "component_rules_create_og_product_for_course_component" : { "node" : [ "node" ] } }
      ]
    }
  }');
  $items['rules_create_og_product_for_course_component'] = entity_import('rules_config', '{ "rules_create_og_product_for_course_component" : {
    "LABEL" : "Create OG Product for course (component)",
    "PLUGIN" : "rule",
    "OWNER" : "rules",
    "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
    "REQUIRES" : [ "rules" ],
    "USES VARIABLES" : { "node" : { "label" : "Node", "type" : "node" } },
    "IF" : [
      { "entity_has_field" : { "entity" : [ "node" ], "field" : "opigno_commerce_product" } },
      { "data_is_empty" : { "data" : [ "node:opigno-commerce-product" ] } },
      { "entity_has_field" : { "entity" : [ "node" ], "field" : "opigno_commerce_price" } },
      { "NOT data_is_empty" : { "data" : [ "node:opigno-commerce-price" ] } }
    ],
    "DO" : [
      { "entity_create" : {
          "USING" : {
            "type" : "commerce_product",
            "param_sku" : "product-og-[node:nid]",
            "param_type" : "og_product",
            "param_title" : "Access [node:title]",
            "param_creator" : [ "node:author" ],
            "param_commerce_price" : [ "node:opigno-commerce-price" ]
          },
          "PROVIDE" : { "entity_created" : { "product" : "Created product" } }
        }
      },
      { "entity_save" : { "data" : [ "product" ], "immediate" : 1 } },
      { "data_set" : { "data" : [ "node:opigno-commerce-product" ], "value" : [ "product" ] } },
      { "entity_save" : { "data" : [ "node" ] } }
    ]
  }
}');
  $items['rules_calculate_og_product_price'] = entity_import('rules_config', '{ "rules_calculate_og_product_price" : {
      "LABEL" : "Calculate OG Product price",
      "PLUGIN" : "reaction rule",
      "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
      "REQUIRES" : [ "rules", "commerce_line_item", "commerce_product_reference" ],
      "ON" : [ "commerce_product_calculate_sell_price" ],
      "IF" : [
        { "component_rules_line_item_is_an_og_product" : { "commerce_line_item" : [ "commerce-line-item" ] } }
      ],
      "DO" : [
        { "component_rules_fetch_og_product_price" : {
            "USING" : { "commerce_line_item" : [ "commerce-line-item" ] },
            "PROVIDE" : { "price" : { "price" : "Price" } }
          }
        },
        { "commerce_line_item_unit_price_amount" : {
            "commerce_line_item" : [ "commerce-line-item" ],
            "amount" : [ "price:amount" ],
            "component_name" : "base_price",
            "round_mode" : "0"
          }
        }
      ]
    }
  }');
  $items['rules_give_access_to_og_on_checkout'] = entity_import('rules_config', '{ "rules_give_access_to_og_on_checkout" : {
      "LABEL" : "Give access to OG on checkout",
      "PLUGIN" : "reaction rule",
      "WEIGHT" : "5",
      "TAGS" : [ "Commerce", "OG", "Opigno", "Opigno Commerce App" ],
      "REQUIRES" : [ "commerce_order", "rules_conditional", "rules", "commerce_checkout" ],
      "ON" : [ "commerce_checkout_complete" ],
      "IF" : [
        { "commerce_order_contains_product_type" : {
            "commerce_order" : [ "commerce-order" ],
            "product_type" : { "value" : { "og_product" : "og_product" } },
            "operator" : "\u003E=",
            "value" : "1"
          }
        }
      ],
      "DO" : [
        { "LOOP" : {
            "USING" : { "list" : [ "commerce-order:commerce-line-items" ] },
            "ITEM" : { "list_item" : "Current list item" },
            "DO" : [
              { "CONDITIONAL" : [
                  {
                    "IF" : { "component_rules_line_item_is_an_og_product" : { "commerce_line_item" : [ "list-item" ] } },
                    "DO" : [
                      { "component_rules_activate_bought_og_membership" : {
                          "commerce_line_item" : [ "list-item" ],
                          "order_owner" : [ "commerce-order:owner" ]
                        }
                      }
                    ]
                  }
                ]
              }
            ]
          }
        }
      ]
    }
  }');
  return $items;
}
