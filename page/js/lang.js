<<<<<<< HEAD
<<<<<<< HEAD
﻿function lang(data) {
    this.words = data;
}

lang.prototype.translate = function (word) {

    try {

        if (word in this.words) {
            return this.words[word];
        } else {
            return word;
        }
    }
    catch (e){
        console.log(e);
        return word ;
    }

}
=======
﻿function lang(data) {
    this.words = data;
}

lang.prototype.translate = function (word) {

    try {

        if (word in this.words) {
            return this.words[word];
        } else {
            return word;
        }
    }
    catch (e){
        console.log(e);
        return word ;
    }

}
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d
=======
﻿function lang(data) {
    this.words = data;
}

lang.prototype.translate = function (word) {

    try {

        if (word in this.words) {
            return this.words[word];
        } else {
            return word;
        }
    }
    catch (e){
        console.log(e);
        return word ;
    }

}
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d
