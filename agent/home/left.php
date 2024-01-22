<? session_start();?>
<?
include "../lib/connect.php";
$dbCon = new dbConn();
?>
<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('이용권한이 없습니다.');</script>";
	exit;
}
?>
<html>
<head>
<title>웹사이트관리</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="../lib/admin.css" type="text/css">
</head>


<SCRIPT LANGUAGE="JavaScript">
function Folder(folderDescription, hreference) //constructor
{
    //constant data;
    this.desc = folderDescription;
    this.hreference = hreference;
    this.id = -1;
    this.navObj = 0;
    this.iconImg = 0;
    this.nodeImg = 0;
    this.isLastNode = 0;

    // dynamic data
    this.isOpen = true;
    this.iconSrc = "leftfolderopen.gif";
    this.children = new Array;
    this.nChildren = 0;

    // methods
    this.initialize = initializeFolder;
    this.setState = setStateFolder;
    this.addChild = addChild;
    this.createIndex = createEntryIndex;
    this.hide = hideFolder;
    this.display = display;
    this.renderOb = drawFolder;
    this.totalHeight = totalHeight;
    this.subEntries = folderSubEntries;
    this.outputLink = outputFolderLink;
}



function setStateFolder(isOpen)
{
  var subEntries;
  var totalHeight;
  var fIt = 0;
  var i = 0;

  if(isOpen == this.isOpen)
      return

  if(browserVersion == 2) {
      totalHeight = 0
      for(i = 0; i < this.nChildren; i++)
          totalHeight = totalHeight + this.children[i].navObj.clip.height;
      subEntries = this.subEntries();

      if(this.isOpen)
          totalHeight = 0 - totalHeight;

      for(fIt = this.id + subEntries + 1; fIt < nEntries; fIt++)
          indexOfEntries[fIt].navObj.moveBy(0, totalHeight);
  }

  this.isOpen = isOpen;
  propagateChangesInState(this);
}



function propagateChangesInState(folder)
{
  var i=0

  if (folder.isOpen)
  {
    if (folder.nodeImg)
      if (folder.isLastNode)
        folder.nodeImg.src = "../images/leftftv2mlastnode.gif"
      else
   folder.nodeImg.src = "../images/leftminus.gif"
    folder.iconImg.src = "../images/leftfolderopen.gif"
    for (i=0; i<folder.nChildren; i++)
      folder.children[i].display()
  }
  else
  {
    if (folder.nodeImg)
      if (folder.isLastNode)
        folder.nodeImg.src = "../images/leftftv2plastnode.gif"
      else
   folder.nodeImg.src = "../images/leftplus.gif"
    folder.iconImg.src = "../images/leftfolderclosed.gif"
    for (i=0; i<folder.nChildren; i++)
      folder.children[i].hide()
  }
}


function hideFolder()
{
    if(browserVersion == 1) {
        if(this.navObj.style.display == "none")
            return
        this.navObj.style.display = "none"
    }
    else {
        if(this.navObj.visibility == "hiden")
            return
        this.navObj.visibility = "hiden"
    }

    this.setState(0)
}


function initializeFolder(level, lastNode, leftSide)
{
    var i = 0;
    var j = 0;

    var numberOfFolders;
    var numberOfDocs;
    var nc;

    nc = this.nChildren;
    this.createIndex();

    var auxEv = "";

    if(browserVersion > 0)
        auxEv = "<a href='javascript:clickOnNode("+this.id+")'>"
    else
        auxEv = "<a>"


    if(level > 0) {
        if(lastNode) { //the last 'brother' in the children array
           this.renderOb(leftSide + auxEv + "<img width='21' height='21' name='nodeIcon" + this.id + "' src='../images/leftftv2mlastnode.gif' width=16 height=22 border=0></a>");
           leftSide = leftSide + "<img src='../images/leftftv2blank.gif' width=16 height=22>";
           this.isLastNode = 1;
        }
        else {
            this.renderOb(leftSide + auxEv + "<img width='21' height='21' name='nodeIcon" + this.id + "' src='../images/leftminus.gif' width=16 height=22 border=0></a>");
            leftSide = leftSide + "<img src='../images/leftftv2vertline.gif' width=16 height=22>";
            this.isLastNode = 0;
        }
    }
    else
        this.renderOb("");


    if(nc > 0) {
        level = level + 1;
        for(i = 0; i < this.nChildren; i++) {
            if(i == this.nChildren-1)
                this.children[i].initialize(level, 1, leftSide);
            else
                this.children[i].initialize(level, 0, leftSide);
        }
    }
}



function drawFolder(leftSide)
{
  if (browserVersion == 2) {
    if (!doc.yPos)
      doc.yPos=8
    doc.write("<layer id='folder" + this.id + "' top=" + doc.yPos + " visibility=hiden>")
  }

  doc.write("<table class='leftmode' width=5 ")
  if (browserVersion == 1)
    doc.write(" id='folder" + this.id + "' style='position:block;' ")
  doc.write(" border=0 cellspacing=0 cellpadding=0>")
  doc.write("<tr><td>")
  doc.write(leftSide)
  this.outputLink()
  doc.write("<img name='folderIcon" + this.id + "' ")
  doc.write("src='../images/" + this.iconSrc+"' border=0></a>")
  doc.write("</td><td nowrap>")

  doc.write("<DIV CLASS=\"fldrroot\">");
  if (USETEXTLINKS)
  {
    this.outputLink()
    doc.write(this.desc + "</a>")
  }
  else
    doc.write(this.desc)

  doc.write("</DIV>");



  doc.write("</td>")
  doc.write("</table>")

  if (browserVersion == 2) {
    doc.write("</layer>")
  }


  if (browserVersion == 1) {
    this.navObj = doc.all["folder"+this.id]
    this.iconImg = doc.all["folderIcon"+this.id]
    this.nodeImg = doc.all["nodeIcon"+this.id]
  } else if (browserVersion == 2) {
    this.navObj = doc.layers["folder"+this.id]
    this.iconImg = this.navObj.document.images["folderIcon"+this.id]
    this.nodeImg = this.navObj.document.images["nodeIcon"+this.id]
    doc.yPos=doc.yPos+this.navObj.clip.height
  }
}

function outputFolderLink()
{
  if (this.hreference)
  {
    if (browserVersion > 0)
      doc.write("<a href ='javascript:clickOnNode("+this.id+")'")
    doc.write("><font color='483200'><b>")
  }
  else
    doc.write("<a>")
//  doc.write("<a href='javascript:clickOnFolder("+this.id+")'>")
}

function addChild(childNode)
{
  this.children[this.nChildren] = childNode
  this.nChildren++
  return childNode
}

function folderSubEntries()
{
  var i = 0
  var se = this.nChildren

  for (i=0; i < this.nChildren; i++){
    if (this.children[i].children) //is a folder
      se = se + this.children[i].subEntries()
  }

  return se
}


// Definition of class Item (a document or link inside a Folder)
// *************************************************************

function Item(itemDescription, itemLink, itemImg) // Constructor
{
  // constant data
  this.desc = itemDescription

  this.link = itemLink

  this.id = -1 //initialized in initalize()
  this.navObj = 0 //initialized in render()
  this.iconImg = 0 //initialized in render()

// iconSrc에 지정되는 이미지 파일을 각 아이템에 맞게 지정할 수 있도록 한다 (목표)
  this.iconSrc = itemImg;

  // methods
  this.initialize = initializeItem
  this.createIndex = createEntryIndex
  this.hide = hideItem
  this.display = display
  this.renderOb = drawItem
  this.totalHeight = totalHeight
}


function hideItem()
{
  if (browserVersion == 1) {
    if (this.navObj.style.display == "none")
      return
    this.navObj.style.display = "none"
  } else {
    if (this.navObj.visibility == "hiden")
      return
    this.navObj.visibility = "hiden"
  }
}

function initializeItem(level, lastNode, leftSide)
{
  this.createIndex()

  if (level>0)
    if (lastNode) //the last 'brother' in the children array
    {
      this.renderOb(leftSide + "<img src='../images/leftftv2lastnode.gif' width=16 height=22>")
      leftSide = leftSide + "<img src='../images/leftftv2blank.gif' width=16 height=22>"
    }
    else
    {
      this.renderOb(leftSide + "<img src='../images/leftftv2node.gif' width=16 height=22>")
      leftSide = leftSide + "<img src='../images/leftftv2vertline.gif' width=16 height=22>"
    }
  else
    this.renderOb("")
}


function drawItem(leftSide)
{
  if (browserVersion == 2)
    doc.write("<layer id='item" + this.id + "' top=" + doc.yPos + " visibility=hiden>")

  doc.write("<table  class='leftmode' width=5 ")
  if (browserVersion == 1)
    doc.write(" id='item" + this.id + "' style='position:block;' ")
  doc.write(" border=0 cellspacing=0 cellpadding=0>")
  doc.write("<tr><td>")
  doc.write(leftSide)


  if(this.link != "")
      doc.write("<a href=" + this.link + ">")

  doc.write("<img id='itemIcon"+this.id+"' ")
  doc.write("src='../images/"+this.iconSrc+"' border=0>")

  if(this.link != "")
      doc.write("</a>")

  doc.write("</td><td nowrap>")

  doc.write("<DIV CLASS=\"fldritem\">");
  if (USETEXTLINKS) {
  if(this.link != "")
        doc.write("<a href=" + this.link + "><font color='483200'>" + this.desc + "</font></a>")
  else
    doc.write(this.desc)

  }
  else {
    doc.write(this.desc)
  }
  doc.write("</DIV>");

  doc.write("</table>")

  if (browserVersion == 2)
    doc.write("</layer>")

  if (browserVersion == 1) {
    this.navObj = doc.all["item"+this.id]
    this.iconImg = doc.all["itemIcon"+this.id]
  } else if (browserVersion == 2) {
    this.navObj = doc.layers["item"+this.id]
    this.iconImg = this.navObj.document.images["itemIcon"+this.id]
    doc.yPos=doc.yPos+this.navObj.clip.height
  }
}


// Methods common to both objects (pseudo-inheritance)
// ********************************************************

function display()
{
  if (browserVersion == 1)
    this.navObj.style.display = "block"
  else
    this.navObj.visibility = "show"
}

function createEntryIndex()
{
  this.id = nEntries
  indexOfEntries[nEntries] = this
  nEntries++
}

// total height of subEntries open
function totalHeight() //used with browserVersion == 2
{
  var h = this.navObj.clip.height
  var i = 0

  if (this.isOpen) //is a folder and _is_ open
    for (i=0 ; i < this.nChildren; i++)
      h = h + this.children[i].totalHeight()

  return h
}


// Events
// *********************************************************

function clickOnFolder(folderId)
{
  var clicked = indexOfEntries[folderId]

  if (!clicked.isOpen)
    clickOnNode(folderId)

  return

  if (clicked.isSelected)
    return
}


function clickOnNode(folderId)
{
  var clickedFolder = 0
  var state = 0

  clickedFolder = indexOfEntries[folderId]
  state = clickedFolder.isOpen

  clickedFolder.setState(!state) //open<->close
}


function initializeDocument()
{
    if(doc.all)
        browserVersion = 1; //IE4
    else if(doc.layers)
        browserVersion = 2; //NS4
    else
        browserVersion = 0; //other

    foldersTree.initialize(0, 1, "");
    foldersTree.display();

    if(browserVersion > 0) {
        doc.write("<layer top="+indexOfEntries[nEntries-1].navObj.top+">&nbsp;</layer>");

    // close the whole tree
    clickOnNode(0)

    // open the root folder
    clickOnNode(0)
  }
}


// Auxiliary Functions for Folder-Treee backward compatibility
// *********************************************************

function gFldr(description, hreference)
{
    folder = new Folder(description, hreference);
    return folder;
}




function gLnk(target, description, linkData, itemImg)
{
  fullLink = ""

  if (target==0)
  {
    if(linkData != "")
        fullLink = "'"+linkData+"' target=\"content\""
    else
        fullLink = "";
  }
  else
  {
    if (target==1) {
       if(linkData != "")
           fullLink = "'http://"+linkData+"' target=content"
       else
           fullLink = "";

    }
    else { // target == 2
       if(linkData != "")
           fullLink = "'http://"+linkData+"' target=\"content\""
       else
           fullLink = "";

    }
  }

  linkItem = new Item(description, fullLink, itemImg)
  return linkItem
}

function insFldr(parentFolder, childFolder)
{
  return parentFolder.addChild(childFolder)
}

function insDoc(parentFolder, document)
{
  parentFolder.addChild(document)
}


// Global variables
// ****************

USETEXTLINKS = 1;
indexOfEntries = new Array;
nEntries = 0;
doc = document;
browserVersion = 0;
selectedFolder=0;
</SCRIPT>


<body text="483200" cellpadding=0 cellspacing=0 topmargin=0 leftmargin=0 marginheight=0 marginwidth="0" background="../images/leftbg.gif">
<table border="0" cellspacing="0" cellpadding="0" width="201" background="../images/leftbg.gif" class="leftmode" >
  <!--tr>
    <td colspan="3"><img src="../images/lefttitle.gif" width="201" height="30"></td>
  </tr>
  <tr><td colspan="3" height=10></td></tr></tr-->

<script language="JavaScript">
foldersTree = gFldr("웹사이트 관리",  "")

aux1 = insFldr(foldersTree, gFldr("고객지원","admin"))
	insDoc(aux1, gLnk(0, "공지사항",  "ibbsprt.php?part=1", "leftfolderclosed.gif"))
	insDoc(aux1, gLnk(0, "질문과답변",  "ibbsprt.php?part=2", "leftfolderclosed.gif"))
	insDoc(aux1, gLnk(0, "자료실",  "ibbsprt.php?part=4", "leftfolderclosed.gif"))

aux1 = insFldr(foldersTree, gFldr("A/S및견적요청","admin"))
	insDoc(aux1, gLnk(0, "A/S및견적",  "online.php", "leftfolderclosed.gif"))


aux1 = insFldr(foldersTree, gFldr("접속통계관리","admin"))
   insDoc(aux1, gLnk(0, "일자별접속통계",  "statis/dailycount.php", "leftfolderclosed.gif"))

insDoc(foldersTree, gLnk(0, "개인정보관리",  "administrator.php", "leftfolderclosed.gif"))



</script>
 <script language="JavaScript">
initializeDocument();
</script>

<br>

		</td>
	</tr>
  <tr>
    <td colspan="3" valign="top">
      <div align="center"><br>
		 <a href="/" target="_blank"><img src="../images/leftban_user.gif" border="0"></a><br>
		 <br>
        <a href="../logout.php" target="_parent"><img src="../images/leftbbs_logout.gif" width="104" height="20" border="0"></a><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
      </div>
    </td>
  </tr>
 </table>
</body>
</html>