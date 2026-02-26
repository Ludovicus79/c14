/**
 * @param {SVGElement} svg
 * @param {Function} callback
 * @param {jsPDF} callback.pdf
 * */
function svg_to_pdf(svgs, callback) {
  var doc = new jsPDF('landscape', 'pt');
  var count = 0;

  for(var i = 0; i < svgs.length; i++) {
    var svg = svgs[i];
    svgAsDataUri(svg, {}, function(svg_uri) {
      var image = document.createElement('img');

      image.src = svg_uri;
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      var dataUrl;

      canvas.width = image.width;
      canvas.height = image.height;
      var altoImp = doc.internal.pageSize.height / 3;
      var anchoImp = (image.width * altoImp) / image.height;
      var offset = (doc.internal.pageSize.width - anchoImp)/2;
      context.drawImage(image, 0, 0, image.width, image.height);
      dataUrl = canvas.toDataURL('image/jpeg');
      doc.addImage(dataUrl, 'JPEG', offset, altoImp*count, anchoImp, altoImp);
    });
    count++;
  }

  callback(doc);
}

/**
 * @param {string} name Name of the file
 * @param {string} dataUriString
*/
function download_pdf(name, dataUriString) {
  var link = document.createElement('a');
  link.addEventListener('click', function(ev) {
    link.href = dataUriString;
    link.download = name;
    document.body.removeChild(link);
  }, false);
  document.body.appendChild(link);
  link.click();
}
