#!/bin/bash

apt-get update && apt-get upgrade -y &&
apt-get install -y autoconf automake build-essential git libass-dev libfaac-dev libgpac-dev \
  libmp3lame-dev libopus-dev libtheora-dev libtool libvorbis-dev libvpx-dev pkg-config texi2html \
  zlib1g-dev

cd /usr/local/src/ && \
mkdir ffmpeg_sources && \
cd ffmpeg_sources/

wget http://www.tortall.net/projects/yasm/releases/yasm-1.2.0.tar.gz && \
tar -xvf yasm-1.2.0.tar.gz && \
cd yasm-1.2.0 && \
./configure --prefix="/usr/local/src/ffmpeg_build" --bindir="/usr/local/bin" && \
make && make install && make distclean && \
cd .. && \
rm -Rf yasm-1.2.0.tar.gz yasm-1.2.0

git clone --depth 1 git://git.videolan.org/x264.git && \
cd x264 && \
./configure --prefix="/usr/local/src/ffmpeg_build" --bindir="/usr/local/bin" --enable-static && \
make && make install && make distclean && \
cd ..

git clone --depth 1 git://github.com/mstorsjo/fdk-aac.git && \
cd fdk-aac && \
autoreconf -fiv && \
./configure --prefix="/usr/local/src/ffmpeg_build" --bindir="/usr/local/bin" --disable-shared && \
make && make install && make distclean && \
cd ..

git clone --depth 1 git://source.ffmpeg.org/ffmpeg && \
cd ffmpeg && \
./configure --prefix="/usr/local/src/ffmpeg_build" --extra-cflags="-I/usr/local/src/ffmpeg_build/include" \
  --extra-ldflags="-L/usr/local/src/ffmpeg_build/lib" --bindir="/usr/local/bin" --extra-libs="-ldl" --enable-gpl \
  --enable-libass --enable-libfaac --enable-libfdk-aac --enable-libmp3lame --enable-libopus --enable-postproc \
  --enable-libtheora --enable-libvorbis --enable-libvpx --enable-libx264 --enable-nonfree && \
make && make install && make distclean && \
hash -r && \
cd ..