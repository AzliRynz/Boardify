# Boardify

## Overview

Boardify is a lightweight plugin for PocketMine-MP that allows you to easily create dynamic, customizable scoreboards for players in your Minecraft server. This plugin can display player statistics such as name, online players, ping, position, health, and more, directly on the sidebar.

## Features

- Display a customizable scoreboard on the sidebar.
- Automatically updates player stats like ping, position, health, and playtime.
- Easy-to-use configuration system to customize what gets displayed on the board.
- Clean and efficient integration with PocketMine's networking system.
- Supports player join event to create the board automatically when players join.

## Installation

1. **Download the Plugin:**
   - Download the latest release of **Boardify** from the poggit or plugin repository.
   
2. **Upload the Plugin:**
   - Place the plugin file (`Boardify.phar`) into the `plugins` folder of your PocketMine-MP server.

3. **Restart the Server:**
   - Restart your server to load the plugin.

4. **Configuration:**
   - Upon the first launch, the plugin will generate a configuration file (`config.yml`) in the plugin's folder. You can edit this file to customize the board's appearance and the information displayed.

## Configuration

The `config.yml` file allows you to modify the appearance and content of the scoreboard. Below is a sample configuration:

```yaml
title: "Boardify"
lines:
  - "Name: {player}"
  - "Online: {online}"
  - "Ping: {ping}"
  - "Health: {health}/{max_health}"
  - "Pos: {x}, {y}, {z}"
```
**Placeholder Details:**

* {player} - Player's username

* {online} - Current number of online players

* {ping} - Player's ping

* {world} - The world the player is currently in

* {x}, {y}, {z} - Player's position coordinates

* {health} - Player's current health

* {max_health} - Player's maximum health

Feel free to modify the lines section to show the stats you want!

## Commands

Currently, the plugin does not have any custom commands. The scoreboard is automatically shown when a player joins the server.

## Events

**PlayerJoinEvent:** The plugin listens for the PlayerJoinEvent, automatically creating the scoreboard when a player joins.

**UpdateBoards:** The plugin updates all players' scoreboards periodically with fresh data.


## Troubleshooting

Board not showing up? Ensure that the plugin is properly installed in the plugins folder and that your PocketMine-MP server is up to date.

**Customizing the scoreboard:** If you're having trouble adjusting the layout, make sure that your config.yml file is properly formatted. The plugin automatically updates as you change the config file.


## Contributing

Feel free to fork the repository and submit pull requests if you want to contribute to the development of the Boardify plugin. If you have any bug reports or feature suggestions, please open an issue in the repository.

## License

This project is licensed under the MIT License.

## Contact

For any inquiries or support, please contact the project maintainer via GitHub Issues or by emailing nurazligaming@gmail.com.

Happy gaming, and enjoy your dynamic scoreboards!
