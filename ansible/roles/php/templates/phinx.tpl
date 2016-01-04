paths:
    migrations: %%PHINX_CONFIG_DIR%%/whatsapp/Db/migrations
    seeds: %%PHINX_CONFIG_DIR%%/whatsapp/Db/seeds

environments:
    default_migration_table: phinxlog
    default_database: migration

    migration:
        adapter: mysql
        host: localhost
        name: whatsapp
        user: root
        pass: '{{mysql.root_password}}'
        port: 3306
        charset: utf8

    production:
        adapter: mysql
        host: localhost
        name: whatsapp
        user: root
        pass: '{{mysql.root_password}}'
        port: 3306
        charset: utf8
