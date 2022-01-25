FROM litespeedtech/openlitespeed:1.7.11-lsphp74

COPY ./ /var/www/vhosts/localhost/html/webApi/ 

COPY ./lsws/vhconf.conf /usr/local/lsws/conf/vhosts/Example/vhconf.conf

EXPOSE 80