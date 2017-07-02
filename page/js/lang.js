function lang(data) {
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
