BASE = ../../../php
CFLAGS = -Wall -g -mmacosx-version-min=10.9 -isysroot /Applications/Xcode.app/Contents/Developer/Platforms/MacOSX.platform/Developer/SDKs/MacOSX10.9.sdk \
       -I$(BASE) \
        -I$(BASE)/main \
        -I$(BASE)/Zend \
        -I$(BASE)/ext/standard \
        -I$(BASE)/TSRM \
        -I$(BASE)/sapi/embed
LFLAGS =-mmacosx-version-min=10.9 -isysroot /Applications/Xcode.app/Contents/Developer/Platforms/MacOSX.platform/Developer/SDKs/MacOSX10.9.sdk -lresolv  -ldl -lstdc++ -L$(BASE)/libs -lphp5

app: encore.lo
	$(BASE)/libtool --mode=link gcc  $(LFLAGS) -g -O2  encore.lo -o app

encore.lo: encore.c
	$(BASE)/libtool --mode=compile gcc  -g -O2 $(CFLAGS) -c encore.c

clean:
	rm -f encore.o encore.lo .libs/encore.o app
