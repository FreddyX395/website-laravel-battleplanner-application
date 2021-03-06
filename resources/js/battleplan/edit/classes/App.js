var Battleplan = require('./Battleplan.js').default;
var Canvas = require('./Canvas.js').default;
var Keybinds = require('./Keybinds.js').default;
var SocketListener = require('./SocketListener.js').default;
var Lobby = require('./Lobby.js').default;

// import 'jquery-ui';

class App {

    /**************************
            Constructor
    **************************/

    constructor(user, lobbyData, socket, viewport, slots, lobbyList, hostLeftSceen, savingScreen) {
    
        // Settings
        this.emptyOperator = 'https://battleplanner.s3.ca-central-1.amazonaws.com/static/EmptyOperator.png'

        // saved parameters
        this.user = user;
        this.lobbyData=lobbyData;
        this.socket = socket;
        this.viewport = viewport
        this.slots = slots;
        this.lobbyList = lobbyList;
        this.hostLeftSceen = hostLeftSceen;
        this.savingScreen = savingScreen;

        // Properties
        this.canvas;                    // Canvas data and logic
        this.map;                       // Saved Map Data (map & floors)
        this.battleplan;                // Saved battleplan instance
        this.keybinds;                  // Definition of keybind actions
        this.lobby;
        this.socketListener;
        
        //Drawing settings
        this.color = '#ffffff';
        this.opacity = 1;
        this.lineSize = 5;
        this.iconSizeModifier = 1

        // Button statuses
        this.buttonEvents = {
            "lmb": {
                "active": false,
                "tool": null
            },
            "rmb": {
                "active": false,
                "tool": null
            },
            "mmb": {
                "active": false,
                "tool": null
            },
        }

        // Initialize variables
        this.keybinds = new Keybinds(this);
        
        if(lobbyData && this.socket){
            this.lobby = new Lobby(lobbyData);
            this.socketListener = new SocketListener(this.socket, this, hostLeftSceen);
        }

        this.canvas = new Canvas(this,this.viewport);       // Initialize canvas
    }

    /**
     * Setup the battleplan from API data
     * - Initialize key eventlisteners
     * - Get Map data
     * - Initialize new battleplan
     */
    initializeByApi(id){
        // Initialize Battleplan hierarchy
        this.battleplan = new Battleplan(id)
        this.battleplan.initializeByApi(this.slots, this.emptyOperator, function(){
            this.canvas.Initialize();
            this.DisplayOperators();
        }.bind(this));

    }

    /**
     * Setup the battleplan data from Json data
     */
    initializeByJson(json){
        // Initialize Battleplan hierarchy
        this.battleplan = new Battleplan(json['id'])
        

        this.battleplan.initializeByJson(json['appJson']['battleplan'],this.slots, function(){
            this.canvas.Initialize();
            this.DisplayOperators();
        }.bind(this));

        this.lobby.initializeByJson(json.appJson.lobby);
        this.LobbyDisplayUsers();
    }

    ChangeFloor(increment){
        this.battleplan.ChangeFloor(increment);
        this.canvas.Update();
    }

    ChangeTool(tool){
        this.keybinds.mousePressed.lmb.tool = tool;
    }

    ChangeColor(color){
        this.color = color;
        $('#color-picker').val(color);
    }

    ChangeOpacity(opacity){
        this.opacity = opacity;
    }

    ChangeZoom(level){
        this.canvas.setScale(level);
        $('#zoom-value').val(this.canvas.scale);
    }

    ChangeLineSize(lineSize){
        this.lineSize = lineSize;
    }

    ChangeIconSizeModifier(size){
        this.iconSizeModifier = size;
    }

    LobbyDisplayUsers(){
        var masterClone = this.lobbyList.children().first().clone();
        this.lobbyList.empty();
        this.lobby.users.forEach(lobbyUser => {
            var clone = masterClone.clone();
            clone.text(lobbyUser['user']['username']);
            this.lobbyList.append(clone);
        });
    }
    /**
     * Operator Logic
     */
    DisplayOperators(){
        this.battleplan.operators.forEach(operator => {
            operator.slot.attr( "src", operator.operator.src );
            operator.slot.css("color", operator.operator.color );
        });
    }

    ChangeOperator(operatorId,src,color){
        this.battleplan.operator.operator.operatorId = operatorId;
        this.battleplan.operator.operator.src = src;
        this.battleplan.operator.operator.color = color;
        this.DisplayOperators();

        $.ajax({
            method: "POST",
            url: `/lobby/${LOBBY["connection_string"]}/request-operator-slot-change`,
            data: {
                'operatorSlotData' : this.battleplan.operator.operator.ToJson()
            },
            success: function (result) {
                console.log(result);
            }.bind(this),
            
            error: function (result) {
                console.log(result);
            }
        });
    }

    requestBattleplanJson(){
        
        app.socketListener.waitingForJson = true;
        
        $.ajax({
            method: "POST",
            url: `/lobby/${LOBBY["connection_string"]}/request-battleplan`,
            data: {},

            success: function (result) {
                console.log('awaiting json');
            }.bind(this),
            
            error: function (result) {
                console.log(result);
            }

        });
    }

    requestReload(){
        $.ajax({
            method: "POST",
            url: `/lobby/${LOBBY["connection_string"]}/request-reload`,
            data: {},

            success: function (result) {
                console.log(result);
            }.bind(this),
            
            error: function (result) {
                console.log(result);
            }
        });
    }

    /**
     * Save
     */
    SaveAs(){
        this.savingScreen.show();
        $.ajax({
            method: "POST",
            url: `/battleplan/${this.battleplan.id}`,
            data: this.ToJson(),
            success: function (result) {
                // Initialize Battleplan hierarchy
                this.battleplan = new Battleplan(this.battleplan.id)
                this.battleplan.initializeByApi(this.slots, this.emptyOperator, function(){
                    this.canvas.Initialize();
                    this.DisplayOperators();
                    this.savingScreen.hide();
                    this.requestReload();
                }.bind(this));
            }.bind(this),
            
            error: function (result) {
                console.log(result);
            }

        });
    }

    ToJson(){
        return {
            'battleplan' : this.battleplan.ToJson(),
            'name' : $('#bName').val(),
            'description' : $('#bDescription').val(),
            'notes' : $('#bNotes').val(),
            'public' : $('#bPublic').is(':checked'),
            'lobby' : this.lobby.ToJson(),
        }
    }
}
export {
    App as
        default
}
