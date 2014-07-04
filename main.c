#include <stdint.h>
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <unistd.h>

int main(void)
{
char *arguments[] = { "baobab","ho", NULL };
execv("/var/www/Imosoweb/main.sh", arguments);
printf("nane!");
return 0;
}