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

### Example

Input

    'Worcester Chamber Music Society','Various','live concert recording'
    'Richie Havens','Follow','Follow'
    'New Lost City Ramblers','How Can a Poor Man Stand Such Times and Live','The Early Yearts'
    'Eric Andersen','Violets of Dawn','\'Bout Changes and Things'
    'Suzzy Roche','Losing','Holy Smokes'
    'The Carter Family','You\'ve Been a Friend to Me','You\'ve Been a Friend to Me'
    'Mary Gauthier','Jackie\'s Train','Drag Queens In Limosines'
    'Bob Franke','The Silence Of Parting/Trouble In This World','The Heart of the Flower'
    'The Skillet Lickers','Molly Put The Kettle On/Sal\'s Gone To The Cider Mill/Big Ball In Town/Leather Breeches/ A Corn Licker Still In Georgia/Devilish Mary','Molly Put The Kettle On/Sal\'s Gone To The Cider Mill/Big Ball In Town/Leather Breeches/ A Corn Licker Still In Georgia/Devilish Mary'
    'Chatham County Line','The Traveler/Should Have Known/Any Port In A Storm','Tightrope'

Output

    "Worcester Chamber Music Society",Various,"live concert recording",
    "Richie Havens",Follow,Follow,
    "The New Lost City Ramblers","How Can a Poor Man Stand Such Times and Live?","The Early Years 1958 - 1962","Smithsonian Folkways"
    "Eric Andersen","Violets of Dawn","'Bout Changes & Things","Vanguard Records"
    "Suzzy Roche",Losing,"Holy Smokes","Red House Records"
    "The Carter Family","There's No One Like Mother to Me","There's No One Like Mother to Me / No Depression in Heaven","Decca Records"
    "Mary Gauthier","Jackie's Train","Drag Queens in Limousines",
    "Bob Franke","The Silence Of Parting/Trouble In This World","The Heart of the Flower",
    "The Skillet Lickers","Molly Put The Kettle On/Sal\'s Gone To The Cider Mill/Big Ball In Town/Leather Breeches/ A Corn Licker Still In Georgia/Devilish Mary","Molly Put The Kettle On/Sal\'s Gone To The Cider Mill/Big Ball In Town/Leather Breeches/ A Corn Licker Still In Georgia/Devilish Mary",
    "Chatham County Line","Any Port in a Storm",Tightrope,"Yep Roc Records"


#### Thanks

Thanks to Musicbrainz for the service and to Mike Almond and chrisdawson for the client lib.
