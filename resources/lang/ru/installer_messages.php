<?php 

return [
    'back' => 'Предыдущий',
    'environment' => [
        'menu' => [
            'templateTitle' => 'Шаг 3 / Настройки Окружающей Среды',
            'title' => 'параметры среды',
            'desc' => 'Пожалуйста, выберите как вы хотите настроить приложения <код>.env</code> файл.',
            'wizard-button' => 'Настройка Мастера Форм',
            'classic-button' => 'Классический Текстовый Редактор',
        ],
        'wizard' => [
            'templateTitle' => 'Шаг 3 / Настройки Среды | Управляемый Мастер',
            'title' => 'Управляемый <код>.env < / code> мастер',
            'tabs' => [
                'environment' => 'Окружающая среда',
                'database' => 'База данных',
                'application' => 'Приложение',
            ],
            'form' => [
                'name_required' => 'Требуется имя среды',
                'app_name_label' => 'Имя Приложения',
                'app_name_placeholder' => 'Имя Приложения',
                'app_environment_label' => 'Среда Приложения',
                'app_environment_label_local' => 'Местный',
                'app_environment_label_developement' => 'Развитие',
                'app_environment_label_qa' => 'Qa',
                'app_environment_label_production' => 'Производство',
                'app_environment_label_other' => 'Другой',
                'app_environment_placeholder_other' => 'Войдите в свое окружение...',
                'app_debug_label' => 'Отладка Приложения',
                'app_debug_label_true' => 'Правда',
                'app_debug_label_false' => 'Ложный',
                'app_log_level_label' => 'Уровень Журнала Приложений',
                'app_log_level_label_debug' => 'отлаживать',
                'app_log_level_label_info' => 'информация',
                'app_log_level_label_notice' => 'уведомление',
                'app_log_level_label_warning' => 'предупреждение',
                'app_log_level_label_error' => 'ошибка',
                'app_log_level_label_critical' => 'критический',
                'app_log_level_label_alert' => 'тревога',
                'app_log_level_label_emergency' => 'чрезвычайная ситуация',
                'app_url_label' => 'Url-Адрес Приложения',
                'app_url_placeholder' => 'Url-Адрес Приложения',
                'db_connection_failed' => 'Не удалось подключиться к базе данных.',
                'db_connection_label' => 'подключение базы данных',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'базы данных SQLite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Хост Базы Данных',
                'db_host_placeholder' => 'Хост Базы Данных',
                'db_port_label' => 'Порт Базы Данных',
                'db_port_placeholder' => 'Порт Базы Данных',
                'db_name_label' => 'имя базы данных',
                'db_name_placeholder' => 'имя базы данных',
                'db_username_label' => 'Имя Пользователя Базы Данных',
                'db_username_placeholder' => 'Имя Пользователя Базы Данных',
                'db_password_label' => 'пароль базы данных',
                'db_password_placeholder' => 'пароль базы данных',
                'app_tabs' => [
                    'more_info' => 'Дополнительная Информация',
                    'broadcasting_title' => 'Вещание, Кэширование, Сеанс И Очередь',
                    'broadcasting_label' => 'Водитель Трансляции',
                    'broadcasting_placeholder' => 'Водитель Трансляции',
                    'cache_label' => 'Cache Driver',
                    'cache_placeholder' => 'Драйвер Кэша',
                    'session_label' => 'Водитель Сессии',
                    'session_placeholder' => 'Водитель Сессии',
                    'queue_label' => 'Драйвер Очереди',
                    'queue_placeholder' => 'Драйвер Очереди',
                    'redis_label' => 'Драйвер Redis',
                    'redis_host' => 'Хост Redis',
                    'redis_password' => 'Пароль Redis',
                    'redis_port' => 'Порт Редис',
                    'mail_label' => 'Почта',
                    'mail_driver_label' => 'Почтовый Драйвер',
                    'mail_driver_placeholder' => 'Почтовый Драйвер',
                    'mail_host_label' => 'почтовый хост',
                    'mail_host_placeholder' => 'почтовый хост',
                    'mail_port_label' => 'Почтовый Порт',
                    'mail_port_placeholder' => 'Почтовый Порт',
                    'mail_username_label' => 'Имя Пользователя Почты',
                    'mail_username_placeholder' => 'Имя Пользователя Почты',
                    'mail_password_label' => 'Почтовый Пароль',
                    'mail_password_placeholder' => 'Почтовый Пароль',
                    'mail_encryption_label' => 'Шифрование Почты',
                    'mail_encryption_placeholder' => 'Шифрование Почты',
                    'pusher_label' => 'Толкатель',
                    'pusher_app_id_label' => 'Идентификатор Приложения Толкателя',
                    'pusher_app_id_palceholder' => 'Идентификатор Приложения Толкателя',
                    'pusher_app_key_label' => 'Ключ Приложения Толкателя',
                    'pusher_app_key_palceholder' => 'Ключ Приложения Толкателя',
                    'pusher_app_secret_label' => 'Толкатель Приложения Secret',
                    'pusher_app_secret_palceholder' => 'Толкатель Приложения Secret',
                ],
                'buttons' => [
                    'setup_database' => 'Настройка Базы Данных',
                    'setup_application' => 'Установка Приложения',
                    'install' => 'Устанавливать',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Шаг 3 / Настройки Среды | Классический Редактор',
            'title' => 'Классический Редактор Окружения',
            'save' => 'Сохранить.ОКР',
            'back' => 'Мастер Использования Форм',
            'install' => 'Сохранить и установить',
        ],
        'success' => 'Ваш.настройки env-файла были сохранены.',
        'errors' => 'Не удалось сохранить его .env файл, пожалуйста, создайте его вручную.',
    ],
    'final' => [
        'title' => 'Установка Закончена',
        'templateTitle' => 'Установка Закончена',
        'finished' => 'Приложение было успешно установлено.',
        'migration' => 'Миграция И Вывод Начальной Консоли:',
        'console' => 'Вывод Консоли Приложения:',
        'log' => 'Запись В Журнале Установки:',
        'env' => 'Окончательный.env файл:',
        'exit' => 'Нажмите здесь, чтобы выйти',
    ],
    'finish' => 'Устанавливать',
    'forms' => [
        'errorTitle' => 'Произошли следующие ошибки:',
    ],
    'install' => 'Устанавливать',
    'installed' => [
        'success_log_message' => 'Laravel Installer успешно установлен на',
    ],
    'next' => 'следующий шаг',
    'permissions' => [
        'templateTitle' => 'Шаг 2 / Разрешения',
        'title' => 'Разрешения',
        'next' => 'Настройка Среды',
    ],
    'requirements' => [
        'templateTitle' => 'Шаг 1 / Требования К Серверу',
        'title' => 'Требования К Серверу',
        'next' => 'Проверка Разрешений',
    ],
    'title' => 'Установщик Laravel',
    'updater' => [
        'title' => 'Laravel обновлен',
        'welcome' => [
            'title' => 'Добро Пожаловать В Программу Обновления',
            'message' => 'Добро пожаловать в мастер обновления.',
        ],
        'overview' => [
            'title' => 'Обзор',
            'message' => 'Есть 1 обновление.|Есть: обновления номеров.',
            'install_updates' => 'установить обновления',
        ],
        'final' => [
            'title' => 'Законченный',
            'finished' => 'База данных приложения была успешно обновлена.',
            'exit' => 'Нажмите здесь, чтобы выйти',
        ],
        'log' => [
            'success_message' => 'Установщик Laravel успешно обновлен на',
        ],
    ],
    'welcome' => [
        'templateTitle' => 'Добро пожаловать',
        'title' => 'Установщик Laravel',
        'message' => 'Простой мастер установки и настройки.',
        'next' => 'Требования К Проверке',
    ],
];