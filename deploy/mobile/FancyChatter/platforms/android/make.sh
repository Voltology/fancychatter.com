#!/bin/sh

cordova build android --release
ant clean release
jarsigner -keystore app_signing.keystore -digestalg SHA1 -sigalg MD5withRSA bin/FancyChatter-release-unsigned.apk release
zipalign -v 4 bin/FancyChatter-release-unsigned.apk bin/FancyChatter.apk
