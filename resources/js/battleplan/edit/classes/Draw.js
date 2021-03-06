var Databaseable = require('./Databaseable.js').default;

class Draw extends Databaseable{

    /**************************
            Constructor
    **************************/
    constructor(id) {
        // Properties
        super(id);
    }

    draw(canvas){
        // Should be overriden in child
    }

    /**************************
        Helper functions
    **************************/
   
    
    UpdateFromJson(json){
        // Should be overriden in child
    }
    
    // Method to see if object is inside a given bounding box.
    // Used for the selection tool
    inBox(canvas,box){
        // Should be overriden in child
        return false;
    }

    // Highlights object
    Highlight(canvas){
        // Should be overriden in child
    }

    Move(dX,dY){
        this.updated = true;
        // Should be overriden in child
    }

}
export {
    Draw as
    default
}