/*  Copyright 2012  Silabsoft  (email : admin@silabsoft.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
var runescape = (function(){
var image_dir;
  function render(activity){
    var i = 0, fragment = '', skillTotal = '';
    var t = document.getElementById('rs-highscores');
    for(i = 0; i < activity.length; i++) {
		if(activity[i].isSkill){
			fragment += '<li id="'+activity[i].name.toLowerCase()+'"><b>'+activity[i].level+'</b></li>';
		}
		else{
			fragment += '<li id="'+activity[i].name.toLowerCase().replace(" ","").replace(".","").replace(" ","")+'"><b>'+(activity[i].score == -1 ?"None" : activity[i].score) +'</b></li>';
		}
    }
    t.innerHTML = fragment;
  }

  return {
    options: {},
    parseHighscores: function(result) {
      if (!result || !result.data) {
        return;
      }
      var data = result.data;
      var activity = [];
      for (var i = 0; i < data.length; i++) {
	    if (!this.options.show_activities && !data[i].isSkill) {
          continue;
        }
        activity.push(data[i]);
      }
      render(activity);
    },
    showHighscore: function(options){
      var req = "http://silabsoft.org/rs-web/highscore.php?player="+options.user+"&callback=runescape.parseHighscores";
      var head = document.getElementsByTagName("head").item(0);
      var script = document.createElement("script");
      this.options = options;
      script.setAttribute("type", "text/javascript");
      script.setAttribute("src", req);
      head.appendChild(script);   
    }
  };
})();
