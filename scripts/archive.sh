# should add version here
git archive master | bzip2 > /tmp/cornac.tbz2
git archive master | gzip > /tmp/cornac.tgz
git archive --format zip --output /tmp/cornac.zip master