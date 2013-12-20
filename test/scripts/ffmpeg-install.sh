#!/bin/bash
# This script works great on travis ci!

sudo apt-get update && sudo apt-get upgrade -y && \
sudo apt-get install -y autoconf automake build-essential git libass-dev libgpac-dev \
  libmp3lame-dev libopus-dev libtheora-dev libtool libvorbis-dev libvpx-dev pkg-config texi2html \
  zlib1g-dev

cd /usr/local/src/ && \
sudo mkdir ffmpeg_sources && \
cd ffmpeg_sources/

sudo wget http://www.tortall.net/projects/yasm/releases/yasm-1.2.0.tar.gz && \
sudo tar -xvf yasm-1.2.0.tar.gz && \
cd yasm-1.2.0 && \
sudo ./configure --prefix="/usr/local/src/ffmpeg_build" --bindir="/usr/local/bin" && \
sudo make && sudo make install && sudo make distclean && \
cd .. && \
sudo rm -Rf yasm-1.2.0.tar.gz yasm-1.2.0

sudo git clone --depth 1 git://git.videolan.org/x264.git && \
cd x264 && \
sudo ./configure --prefix="/usr/local/src/ffmpeg_build" --bindir="/usr/local/bin" --enable-static && \
sudo make && sudo make install && sudo make distclean && \
cd ..

sudo git clone --depth 1 git://github.com/mstorsjo/fdk-aac.git && \
cd fdk-aac && \
sudo autoreconf -fiv && \
sudo ./configure --prefix="/usr/local/src/ffmpeg_build" --bindir="/usr/local/bin" --disable-shared && \
sudo make && sudo make install && sudo make distclean && \
cd ..

sudo git clone --depth 1 git://source.ffmpeg.org/ffmpeg && \
cd ffmpeg && \
sudo ./configure --prefix="/usr/local/src/ffmpeg_build" --extra-cflags="-I/usr/local/src/ffmpeg_build/include" \
  --extra-ldflags="-L/usr/local/src/ffmpeg_build/lib" --bindir="/usr/local/bin" --extra-libs="-ldl" --enable-gpl \
  --enable-libfdk-aac --enable-libmp3lame --enable-libopus --enable-postproc \
  --enable-libtheora --enable-libvorbis --enable-libvpx --enable-libx264 --enable-nonfree && \
sudo make && sudo make install && sudo make distclean && \
hash -r && \
cd ..