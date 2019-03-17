FROM amazonlinux:2

RUN yum update -y
RUN yum upgrade -y

#タイムゾーン設定
# RUN timedatectl set-timezone Asia/Tokyo

# 日本語設定
RUN yum install -y glibc-langpack-ja
RUN export LANG='ja_JP.utf8'

# nginxインストール&起動
RUN amazon-linux-extras install nginx1.12
RUN nginx

# phpインストール
RUN amazon-linux-extras install php7.2

# php-fpmインストール
RUN yum install -y php-fpm

# php-fpm設定
RUN sed -i 's/user\ \=\ apache/user = nginx/g' /etc/php-fpm.d/www.conf
RUN sed -i 's/group\ \=\ apache/group = nginx/g' /etc/php-fpm.d/www.conf

# nginxの設定
# docker-composeで共有するのでコメントアウト
# ADD ./nginx.conf /etc/nginx/nginx.conf

# コンパイルに必要
RUN yum install -y php-devel pcre-devel gcc make

# gitからphalconビルドソースを取得
RUN yum install -y git
RUN git clone -b v3.4.2 --depth=1 "git://github.com/phalcon/cphalcon.git"

# ビルド中に必要と言われるが、yumでは取得できないのでコメントアウト
#RUN yum install -y re2c

# ビルド。めっちゃ時間かかる
RUN cd cphalcon/build && \
    ./install

# extension追加
RUN echo "extension=phalcon.so" > /etc/php.d/phalcon.ini

# composerを使ってdev-toolsをインストール
RUN curl -s http://getcomposer.org/installer | php
RUN echo '{"require": {"phalcon/devtools": "dev-master"}}' > composer.json

# composerインストール時に必要
RUN yum install -y zip unzip
RUN php composer.phar install

# シンボリックリンク作成
RUN ln -s /vendor/phalcon/devtools/phalcon.php /usr/bin/phalcon

# 権限の設定。今のところ不必要なのでコメントアウト
#RUN chmod ugo+x /usr/bin/phalcon

RUN mkdir /var/www

# 汎用的なDockerimageのため、プロジェクトは作らない
# RUN cd /var/www && phalcon project phalcon --enable-webtools

# push通知に必要(minishlink/web-push)
RUN yum -y install gmp-devel php-gmp php-mbstring
# デフォルトでの`20-gmp.ini`では効かない
# 強制上書き
RUN echo "extension=gmp.so" >| /etc/php.d/gmp.ini

# google/sdkでのgoogleログインに必要
RUN yum install -y --enablerepo=remi,remi-php70 php-xml

RUN sed -i 's/listen.acl_users\ \=\ apache,nginx/;listen.acl_users = apache,nginx/g' /etc/php-fpm.d/www.conf
RUN sed -i 's/listen\ \=\ \/run\/php-fpm\/www\.sock/listen = \/var\/run\/php-fpm\/www.sock/g' /etc/php-fpm.d/www.conf
RUN sed -i 's/;listen.owner\ \=\ nobody/listen.owner = nginx/g' /etc/php-fpm.d/www.conf
RUN sed -i 's/;listen.group\ \=\ nobody/listen.group = nginx/g' /etc/php-fpm.d/www.conf

# 以降、xdebugのインストール
RUN yum install -y php-pear
RUN pecl install xdebug-2.7.0alpha1
#RUN echo "extension=xdebug.so" > /etc/php.d/xdebug.ini
RUN echo -e 'zend_extension=/usr/lib64/php/modules/xdebug.so\nxdebug.overload_var_dump = 1\nxdebug.remote_enable=1\nxdebug.remote_handler=dbgp\nxdebug.remote_host=docker.for.mac.host.internal\nxdebug.remote_port=9001\nxdebug.remote_autostart=1\nxdebug.profiler_enable=0\nxdebug.profiler_output_dir="/tmp"\nxdebug.max_nesting_level=1000\nxdebug.remote_connect_back=0\nxdebug.idekey="PHPSTORM"\nxdebug.dump.GET=*\nxdebug.dump.POST=*' >> /etc/php.ini

# セッションを有効化
RUN chown nginx /var/lib/php/session

#  awsログ設定
RUN yum install -y awslogs

# タイムゾーン設定
RUN sed -i 's/\;date\.timezone\ \=/date.timezone = "Asia\/Tokyo"/g' /etc/php.ini

# 画像処理ライブラリ
RUN yum install -y php-gd

# 変更が頻繁にあるため、必ず最後
ADD $PWD/phalcon /var/www/phalcon
ADD $PWD/nginx.conf/ /etc/nginx/nginx.conf
RUN chown -R nginx /var/www

# 起動設定
CMD /bin/bash -c "nginx && php-fpm && tail -f /dev/null"
