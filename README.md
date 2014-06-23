## Minor Laravel project featuring Leaflet maps, Sass and GruntJS for asset management

### Laravel features
- Basic Laravel MVC structure (in app/controllers, app/models, app/views)
- 2 layer caching with memcached (complete cache for anonymous and query caching for authenticated users)
- custom macros and helpers are located in /app/helpers
- Other Laravel features include authentication (regular and social authentication), social meta share markup, Rich Text SEO markup

### Front-end
- Front-end files all managed with gruntJS and Sass. Images all *sprited*. Front-end files located in assets/ folder.
- Youtube api integration for generating video thumbnail and initial title
- Leaflet markercluster to manage growing number of tracks with various sorting methods, i.e. "Hot" and "Genre" links all done front-end

[Live demo can be seen  here.](http://mapstr.co)