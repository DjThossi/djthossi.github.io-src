apt-get update
apt-get install -y imagemagick
rm /usr/bin/node > /dev/null 2>&1 || true
ln -s /usr/bin/nodejs /usr/bin/node

rm /etc/nginx/sites-enabled/default > /dev/null 2>&1 || true
cp /vagrant/vagrant/nginx.site.conf /etc/nginx/sites-enabled/nginx.site.conf
service nginx restart

cp /vagrant/vagrant/box.gitconfig /home/vagrant/.gitconfig

if ! grep -q "#added by vagrant provision" "/home/vagrant/.profile"; then
  echo $'\ncd /vagrant #added by vagrant provison' >> /home/vagrant/.profile
fi