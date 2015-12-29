# labeler

Adds record label to playlists.

Input playlist file must be in the format

    Artist,Song,Album
    Artist,Song,Album
    ...

Or with tab separators instead of commas if you give the `-t` option.

It reads from standard input by default and writes to dtandard output, or you may specify files:

    labeler [-t] [in [out]]
      -t   use tab separators rather than commas
      in   input file name, or - for for stdin
      out  output file name, or - for for stdout

It is very slow, using one search and two lookups in [Musicbrainz](http://musicbrainz.org/)
for each item.

Sometimes it can’t find the item in Musicbrainz and sometimes Musicbrainz doesn't have the label
for the item.

Thanks to Musicbrainz for the service and to Mike Almond and chrisdawson for the client lib.