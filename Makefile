all:
	rm -rf output
	mkdir output
	php generate_static_files.php
	cp -r files/* output

clean:
	rm -rf output
