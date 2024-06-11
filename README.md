# PFT Dev Tools
A plugin with a set of utilities is used to develop the product form template system.


## WP-CLI commands

### `trigger`

Trigger a WordPress hook manually.

```sh
wp trigger upgrader_process_complete 
```

#### DESCRIPTION

Trigger a WordPress hook manually.

#### SYNOPSIS

  wp trigger <action> [--action=<action>]

#### OPTIONS

* `<hook-name>`: The name of the hook to trigger.
* `[--action=<action>]`: The action to perform.
  - default: `update`
  - options: `install` | `update` | `delete`

* `[--type=<type>]`: Type of update process.
  - default: `plugin`
  - options: `plugin` | `theme` | `core` | `translation`

### EXAMPLES

```sh
wp trigger woocommerce_after_update_option
wp trigger woocommerce_after_update_option --action=install --type=plugin
```