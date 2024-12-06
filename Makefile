.POSIX:
.PHONY: all
all:
	rm -rf output
	mkdir output
	php generate_static_files.php
	cp -r files/* output

.PHONY: clean
clean:
	rm -rf output
