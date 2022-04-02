/**
 * JavaScript logic for Pet-Slide Puzzle
 *
 * @team Team Pizza
 * @name puzzle.js
 * @usage puzzle.html
 * @dateModefied 2022-02-24
 *
 * @credit Adapted from; https://code.tutsplus.com/tutorials/create-an-html5-canvas-tile-swapping-puzzle--active-10747
 */

/** Global constants */
let PUZZLE_DIFFICULTY = 4;  // Puzzle difficulty n. Creates puzzle of n^2 pieces.
const PUZZLE_HOVER_TINT = '#009900';  // Tint color of puzzle piece currently hovering over
const IMAGE_DIRECTORY = 'img/';
let IMAGE = `${IMAGE_DIRECTORY}dogs.jpg`;

/** Global variables */
let _canvas;  // Canvas element
let _stage;  // Canvas drawing context
let _img;  // Loaded image
let _pieces;  // Array containing the puzzle pieces
let _puzzleWidth;  // Width of the puzzle
let _puzzleHeight;  // Height of the puzzle
let _pieceWidth;  // Width of each puzzle piece
let _pieceHeight;  // Height of each puzzle piece
let _currentPiece;  // Current piece reference
let _currentDropPiece;  // Reference to the piece's position that is being dropped on
let _mouse;  // Reference of mouse's (x, y) position

/**
 * Initialize image for puzzle.
 */
function init() {
	
    _img = new Image();
    _img.addEventListener('load', onImage, false);
    _img.src = IMAGE;
	/*When the user enters the puzzle page, the script should hold onto who they are for use!*/
}


/**
 * Set's global variables according to loaded image.
 *
 * @param e - event context
 */
function onImage(e) {

    _pieceWidth = Math.floor(_img.width / PUZZLE_DIFFICULTY)
    _pieceHeight = Math.floor(_img.height / PUZZLE_DIFFICULTY)
    _puzzleWidth = _pieceWidth * PUZZLE_DIFFICULTY;
    _puzzleHeight = _pieceHeight * PUZZLE_DIFFICULTY;
    setCanvas();
    initPuzzle();
}


/**
 * Setup canvas element for puzzle.
 */
function setCanvas() {

    _canvas = document.getElementById('canvas');
    _stage = _canvas.getContext('2d');
    _canvas.width = _puzzleWidth;
    _canvas.height = _puzzleHeight;
    _canvas.style.border = "1px solid black";
}


/**
 * Initializes puzzle. Has "Start Puzzle" message.
 */
function initPuzzle() {

    _pieces = [];
    _mouse = {x: 0, y: 0};
    _currentPiece = null;
    _currentDropPiece = null;
    _stage.drawImage(_img, 0, 0, _puzzleWidth, _puzzleHeight, 0, 0, _puzzleWidth, _puzzleHeight);
    createTitle("Click to Start Puzzle");
    buildPieces();
}


/**
 * Creates messge for player to start puzzle
 *
 * @param msg - Start message to player
 */
function createTitle(msg) {

    _stage.fillStyle = "#000000";
    _stage.globalAlpha = .4;
    _stage.fillRect(100, _puzzleHeight - 40, _puzzleWidth - 200, 40);
    _stage.fillStyle = "#FFFFFF";
    _stage.globalAlpha = 1;
    _stage.textAlign = "center";
    _stage.textBaseline = "middle";
    _stage.font = "20px Arial";
    _stage.fillText(msg, _puzzleWidth / 2, _puzzleHeight - 20);
}


/**
 * Constructs the individual pieces for the puzzle.
 */
function buildPieces() {

    let i, piece;
    let xPos = 0, yPos = 0;

    for (i = 0; i < PUZZLE_DIFFICULTY * PUZZLE_DIFFICULTY; i++) {
        piece = {};
        piece.sx = xPos;
        piece.sy = yPos;
        _pieces.push(piece);
        xPos += _pieceWidth;
        if (xPos >= _puzzleWidth) {
            xPos = 0;
            yPos += _pieceHeight;
        }
    }
    document.onmousedown = shufflePuzzle;
}

/**
 * Takes array of pieces and shuffles them.
 */
function shufflePuzzle() {

    _pieces = shuffleArray(_pieces);
    _stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);

    let i, piece;
    let xPos = 0, yPos = 0;

    for (i = 0; i < _pieces.length; i++) {

        piece = _pieces[i];
        piece.xPos = xPos;
        piece.yPos = yPos;
        _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, xPos, yPos, _pieceWidth, _pieceHeight);
        _stage.strokeRect(xPos, yPos, _pieceWidth, _pieceHeight);
        xPos += _pieceWidth;

        if (xPos >= _puzzleWidth) {
            xPos = 0;
            yPos += _pieceHeight;
        }
    }

    document.onmousedown = onPuzzleClick;
}


/**
 * Takes passed array, shuffles the elements, and then returns the shuffled aray.
 *
 * @param o - Array to shuffle.
 * @returns {*} - Shuffled array.
 */
function shuffleArray(o) {

    for (let j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x) ;
    return o;
}


/**
 * Determines mouse position when button is clicked and updates puzzle.
 *
 * @param e - event context
 */
function onPuzzleClick(e) {

    if (e.layerX || e.layerX === 0) {
        _mouse.x = e.layerX - _canvas.offsetLeft;
        _mouse.y = e.layerY - _canvas.offsetTop;
    } else if (e.offsetX || e.offsetX === 0) {
        _mouse.x = e.offsetX - _canvas.offsetLeft;
        _mouse.y = e.offsetY - _canvas.offsetTop;
    }

    _currentPiece = checkPieceClicked();
    if (_currentPiece != null) {
        _stage.clearRect(_currentPiece.xPos, _currentPiece.yPos, _pieceWidth, _pieceHeight);
        _stage.save();
        _stage.globalAlpha = .9;
        _stage.drawImage(_img, _currentPiece.sx, _currentPiece.sy, _pieceWidth, _pieceHeight, _mouse.x - (_pieceWidth / 2), _mouse.y - (_pieceHeight / 2), _pieceWidth, _pieceHeight);
        _stage.restore();
        document.onmousemove = updatePuzzle;
        document.onmouseup = pieceDropped;
    }
}


/**
 * Determines which puzzle piece was clicked and returns it.
 *
 * @returns {null|*} - Piece clicked; otherwise, returns null if no piece was clicked
 */
function checkPieceClicked() {

    let i, piece;

    for (i = 0; i < _pieces.length; i++) {
        piece = _pieces[i];
        if (_mouse.x < piece.xPos - _canvas.offsetLeft || _mouse.x > (piece.xPos + _pieceWidth - _canvas.offsetLeft) || _mouse.y < piece.yPos - _canvas.offsetTop || _mouse.y > (piece.yPos + _pieceHeight - _canvas.offsetTop)) {
            //PIECE NOT HIT
        } else {
            return piece;
        }
    }
    return null;
}


/**
 * Updates puzzle
 *
 * @param e - Event context
 */
function updatePuzzle(e) {

    _currentDropPiece = null;
    if (e.layerX || e.layerX === 0) {
        _mouse.x = e.layerX - _canvas.offsetLeft;
        _mouse.y = e.layerY - _canvas.offsetTop;
    } else if (e.offsetX || e.offsetX === 0) {
        _mouse.x = e.offsetX - _canvas.offsetLeft;
        _mouse.y = e.offsetY - _canvas.offsetTop;
    }

    _stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
    let i;
    let piece;
    for (i = 0; i < _pieces.length; i++) {
        piece = _pieces[i];
        if (piece == _currentPiece) {
            continue;
        }
        _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
        _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
        if (_currentDropPiece == null) {
            if (_mouse.x < piece.xPos - _canvas.offsetLeft || 
                _mouse.x > (piece.xPos + _pieceWidth - _canvas.offsetLeft) || 
                _mouse.y < piece.yPos - _canvas.offsetTop || 
                _mouse.y > (piece.yPos + _pieceHeight - _canvas.offsetTop)) {
        
                //NOT OVER
            } else {
                _currentDropPiece = piece;
                _stage.save();
                _stage.globalAlpha = .4;
                _stage.fillStyle = PUZZLE_HOVER_TINT;
                _stage.fillRect(_currentDropPiece.xPos, _currentDropPiece.yPos, _pieceWidth, _pieceHeight);
                _stage.restore();
            }
        }
    }
    _stage.save();
    _stage.globalAlpha = .6;
    _stage.drawImage(_img, _currentPiece.sx, _currentPiece.sy, _pieceWidth, _pieceHeight, _mouse.x - (_pieceWidth / 2) + _canvas.offsetLeft, _mouse.y - (_pieceHeight / 2) + _canvas.offsetTop, _pieceWidth, _pieceHeight);
    _stage.restore();
    _stage.strokeRect(_mouse.x - (_pieceWidth / 2) + _canvas.offsetLeft, _mouse.y - (_pieceHeight / 2) + _canvas.offsetTop, _pieceWidth, _pieceHeight);
}


/**
 *  Swaps clicked piece with piece dropped on.
 *
 * @param e - Event context
 */
function pieceDropped(e) {

    document.onmousemove = null;
    document.onmouseup = null;
    if (_currentDropPiece != null) {
        let tmp = {xPos: _currentPiece.xPos, yPos: _currentPiece.yPos};
        _currentPiece.xPos = _currentDropPiece.xPos;
        _currentPiece.yPos = _currentDropPiece.yPos;
        _currentDropPiece.xPos = tmp.xPos;
        _currentDropPiece.yPos = tmp.yPos;
    }
    resetPuzzleAndCheckWin();
}


/**
 * Resets puzzle then checks for win condition.
 */
function resetPuzzleAndCheckWin() {

    _stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
    let gameWin = true;
    let i, piece;

    for (i = 0; i < _pieces.length; i++) {
        piece = _pieces[i];
        _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
        _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
        if (piece.xPos != piece.sx || piece.yPos != piece.sy) {
            gameWin = false;
        }
    }

    if (gameWin) {
        setTimeout(gameOver, 500);
    }
}

function reInitPuzzle() {
    document.onmousedown = null;
    document.onmousemove = null;
    document.onmouseup = null;
    init();
}


/**
 * Win condition met. Re-initializes puzzle.
 */
function gameOver() {
    reInitPuzzle();
    updatePlayerXp();
}

/**
 * Sets puzzle difficulty to passed value and reinitializes puzzle.
 */
function setDifficulty(diff){

    if (!(2 <= diff && diff <=10)){
        console.log(`ERROR: Invalid puzzle difficulty: ${diff}`);
        return;
    }

    PUZZLE_DIFFICULTY = diff;
    reInitPuzzle();

}

/**
 * Sets puzzle image to passed value and reinitializes puzzle.
 */
function setImage(img){
    IMAGE = `${IMAGE_DIRECTORY}${img}`;
    reInitPuzzle();
}


/**
 * Updates player experience after they successfully complete a game.
 */
function updatePlayerXp(){
    let puzzleDiff = PUZZLE_DIFFICULTY;
	
	console.log("entered into updateXP function");

    $j.ajax({
        url:"php/update_player_xp.php",    //the page containing php script
        type: "post",    //request type,
        dataType: 'json',
        data: {playername: $session_id, diff_lvl: puzzleDiff},
        success:function(result){
            console.log(result.abc);
        }, 
            // reject/failure callback
        failure:function()
        {
            alert('There was some error!');
        }
    });


}