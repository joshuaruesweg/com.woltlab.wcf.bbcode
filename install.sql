DROP TABLE IF EXISTS wcf1_bbcode;
CREATE TABLE wcf1_bbcode (
	bbcodeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	bbcodeTag VARCHAR(255) NOT NULL,
	packageID INT(10) NOT NULL,
	htmlOpen VARCHAR(255) NOT NULL DEFAULT '',
	htmlClose VARCHAR(255) NOT NULL DEFAULT '',
	textOpen VARCHAR(255) NOT NULL DEFAULT '',
	textClose VARCHAR(255) NOT NULL DEFAULT '',
	allowedChildren VARCHAR(255) NOT NULL DEFAULT 'all',
	className VARCHAR(255) NOT NULL DEFAULT '',
	wysiwygIcon varchar(255) NOT NULL DEFAULT '',
	isSourceCode TINYINT(1) NOT NULL DEFAULT 0,
	disabled TINYINT(1) NOT NULL DEFAULT 0,
	UNIQUE KEY bbcodeTag (bbcodeTag)
);

DROP TABLE IF EXISTS wcf1_bbcode_attribute;
CREATE TABLE wcf1_bbcode_attribute (
	attributeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	bbcodeID INT(10) NOT NULL,
	attributeNo TINYINT(3) NOT NULL DEFAULT 0,
	attributeHtml VARCHAR(255) NOT NULL DEFAULT '',
	attributeText VARCHAR(255) NOT NULL DEFAULT '',
	validationPattern VARCHAR(255) NOT NULL DEFAULT '',
	required TINYINT(1) NOT NULL DEFAULT 0,
	useText TINYINT(1) NOT NULL DEFAULT 0,
	UNIQUE KEY attributeNo (bbcodeID, attributeNo)
);

DROP TABLE IF EXISTS wcf1_bbcode_video_provider;
CREATE TABLE wcf1_bbcode_video_provider (
	providerID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	regex TEXT NOT NULL,
	html TEXT NOT NULL
);

DROP TABLE IF EXISTS wcf1_smiley;
CREATE TABLE wcf1_smiley (
	smileyID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	packageID INT(10) NOT NULL,
	smileyCategoryID INT(10),
	smileyPath VARCHAR(255) NOT NULL DEFAULT '',
	smileyTitle VARCHAR(255) NOT NULL DEFAULT '',
	smileyCode VARCHAR(255) NOT NULL DEFAULT '',
	showOrder MEDIUMINT(5) NOT NULL DEFAULT 0,
	UNIQUE KEY smileyCode (smileyCode)
);

DROP TABLE IF EXISTS wcf1_smiley_category;
CREATE TABLE wcf1_smiley_category (
	smileyCategoryID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL DEFAULT '',
	showOrder MEDIUMINT(5) NOT NULL DEFAULT 0,
	disabled TINYINT(1) NOT NULL DEFAULT 0
);

-- foreign keys
ALTER TABLE wcf1_bbcode ADD FOREIGN KEY (packageID) REFERENCES wcf1_package (packageID) ON DELETE CASCADE;

ALTER TABLE wcf1_bbcode_attribute ADD FOREIGN KEY (bbcodeID) REFERENCES wcf1_bbcode (bbcodeID) ON DELETE CASCADE;

ALTER TABLE wcf1_smiley ADD FOREIGN KEY (packageID) REFERENCES wcf1_package (packageID) ON DELETE CASCADE;
ALTER TABLE wcf1_smiley ADD FOREIGN KEY (smileyCategoryID) REFERENCES wcf1_smiley_category (smileyCategoryID) ON DELETE SET NULL;

-- video providers
-- Youtube
INSERT INTO wcf1_bbcode_video_provider (regex, html) VALUES ('~^https?://(?:.+\.)?youtu(?:\.be/|be\.com/watch\?(?:.*)v=)(?<ID>[a-zA-Z0-9_-]+?)~U', '<iframe width="420" height="315" src="http://www.youtube.com/embed/{$ID}" frameborder="0" allowfullscreen></iframe>');
-- Vimeo
INSERT INTO wcf1_bbcode_video_provider (regex, html) VALUES ('~http://vimeo.com/(?<ID>\\d+)~', '<iframe src="http://player.vimeo.com/video/{$ID}" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
-- MyVideo
INSERT INTO wcf1_bbcode_video_provider (regex, html) VALUES ('~http://www.myvideo.de/watch/(?<ID>\\d+)~', '<object style="width:611px;height:383px;" width="611" height="383"><embed src="http://www.myvideo.de/movie/{$ID}" width="611" height="383" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed><param name="movie" value="http://www.myvideo.de/movie/{$ID}"></param><param name="AllowFullscreen" value="true"></param><param name="AllowScriptAccess" value="always"></param></object>');
-- Clipfish
INSERT INTO wcf1_bbcode_video_provider (regex, html) VALUES ('~http://www.clipfish.de/video/(?<ID>\\d+)/~', '<div style="width:464px; height:404px;"><div style="width:464px; height:384px;"><iframe src="http://www.clipfish.de/embed_video/?vid={$ID}&as=0&col=990000" name="Clipfish Embedded Video" width="464" height="384" align="left" marginheight="0" marginwidth="0" frameborder="0" scrolling="no"></iframe></div></div>');