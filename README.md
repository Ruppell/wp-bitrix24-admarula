# WordPress Bitrix24 AdMarula

A WordPress plugin that makes use of Bitrix24 webhooks to pass tracking information to AdMarula.


![Plugin](https://raw.githubusercontent.com/Ruppell/wp-bitrix24-admarula/master/screenshot.png)

## Plugin Settings

The plugin has the following options.

### Bitrix24 Settings

1. **Authentication Code**
    - This code will be given to you after creating an outbound webhook.
2. **Inbound URL**
    - The link to the inbound webhook.
3. **Tracking Property Key**
    - This is the ID of the field that holds the AdMarula tracking information inside the Lead or Deal.
4. **Regular Expression**
    - This reqular expression is used to extract the 36 digit tmt_data tracking code from the field with the above ID.

### AdMarula Settings

1. **Transaction Type**
    - The transaction type (Sale | Lead | Install)
2. **Post Back URL**
    - The AdMarula post back URL.

### Trigger Settings

1. **Trigger When**
    - When the item is of type. (Lead | Deal).
2. **Status ID**
    - Send AdMarula the tracking information when the Lead | Deal status equals any of the following. Remember if you defined non standard status types inside of Bitrix24, they will be given unique number. You can use the Bitrix24 inbound webhook API to find this number.


## Log Files 

This plugin logs all results to two different log files. The AdMarula log and the failures log.

### AdMarula Log

This log file holds all requests made to AdMarula. Each log entry displays the following information.

1. **ID:**
    - The lead or deal ID.
2. **RESPONSE_CODE:**
    - The response code from AdMarula.
3. **RESPONSE_MESSAGE:**
    - The response message from AdMarula.
4. **TYPE:**
    - Is the item a Lead or Deal.
5. **CURRENCY:**
    - The lead | deal currency (3digit ISO4217 approved format).
6. **STATUS:**
    - The lead | deal status, this relates to the Bitrix24 API.
7. **TMTDATA_HEX:**
    - The lead | deals tracking code.
8. **TIMESTAMP:**
    - The time when the request to AdMarula was made.

### Failures Log

1. Post back url returned with a bad status code of [ *STATUS_CODE* ], when 200 was expected.
    - This means that the AdMarula server responded with a bad response.
2. The item does not have the required details!
    - The Bitrix24 lead | deal does not have the required information, to build the AdMarula request. This is most lickly missing tracking information.
