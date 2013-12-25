#include <php_embed.h>
#include <TSRM.h>
#include <SAPI.h>
#include <zend_ini.h>
#include <php.h>
#include <php_ini.h>
#include <php_string.h>
#include <unistd.h>
#include <libgen.h>

char* join(char *parent,char *add)
{
    char* buffer = (char*) malloc( strlen(parent) + 1 + strlen(add) + 1);  

    strcpy(buffer, parent);
    strcat(buffer, add);

    return buffer;
}

int main(int argc, char **argv)
{
    int retval = SUCCESS;

    char *code = "if (file_exists($file = __DIR__.\"/Resources/app.phar\")) {"
        "require $file;"
    "} else {"
        "echo 'Could not locate app archive'.PHP_EOL;"
    "}";

    char buf[PATH_MAX];
    char* dir = dirname(buf);

    php_embed_module.php_ini_ignore = 0;
    php_embed_module.php_ini_path_override = "./embed.ini";

    PHP_EMBED_START_BLOCK(argc,argv);
    zend_alter_ini_entry("extension_dir", 14, dir, strlen(dir), PHP_INI_ALL, PHP_INI_STAGE_ACTIVATE);
    zend_alter_ini_entry("error_reporting", 16, "0", 1, PHP_INI_ALL, PHP_INI_STAGE_ACTIVATE);
    retval = zend_eval_string(code, NULL, argv[0] TSRMLS_CC) == SUCCESS ? EXIT_SUCCESS : EXIT_FAILURE;
    PHP_EMBED_END_BLOCK();

    exit(retval);
}
