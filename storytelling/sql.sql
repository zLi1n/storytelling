CREATE DATABASE Storytelling;
USE Storytelling;

CREATE TABLE User (
    Email VARCHAR(255) PRIMARY KEY,
    Username VARCHAR(50),
    Name VARCHAR(100),
    DOB DATE,
    Password VARCHAR(255),
    RegistrationDate DATE,
    Avatar VARCHAR(255),
    Signature VARCHAR(255),
    BackgroundTheme VARCHAR(50),
    Type VARCHAR(1),
    SecurityQuestion VARCHAR(255),
    SecurityQuestionAns VARCHAR(255)
);

CREATE TABLE Genre (
    GenreID INT PRIMARY KEY,
    GenreDetail VARCHAR(255)
);

CREATE TABLE Theme (
    ThemeID INT PRIMARY KEY,
    ThemeDetail VARCHAR(255)
);

CREATE TABLE Story (
    StoryID INT PRIMARY KEY,
    Email VARCHAR(255),
    GenreID INT,
    ThemeID INT,
	Title VARCHAR(255),
    Access VARCHAR(3),
    CoverPage VARCHAR(255),
    Status VARCHAR(1),
    DateTime DATETIME,
    ContributionLoop INT,
    FOREIGN KEY (GenreID) REFERENCES Genre(GenreID),
    FOREIGN KEY (Email) REFERENCES User(Email),
    FOREIGN KEY (ThemeID) REFERENCES Theme(ThemeID)
);

/*DROP TABLE ReportedContent;
DROP TABLE Comment;
DROP TABLE Vote;
DROP TABLE Contribution;
DROP TABLE Chapter;*/

CREATE TABLE Chapter (
    ChapterID INT PRIMARY KEY,
	Email VARCHAR(255),
    StoryID INT,
    ChapBeforeID INT,
    ChapterName VARCHAR(255),
    Content TEXT,
    Status VARCHAR(1),
    DateTime DATETIME,
	Ending BOOLEAN,
    FOREIGN KEY (Email) REFERENCES User(Email),
    FOREIGN KEY (StoryID) REFERENCES Story(StoryID),
    FOREIGN KEY (ChapBeforeID) REFERENCES Chapter(ChapterID)
);

CREATE TABLE Invitation (
    InvitationID INT PRIMARY KEY,
    SenderEmail VARCHAR(255),
    ReceiverEmail VARCHAR(255),
    ChapterID INT,
	Link VARCHAR(255),
    FOREIGN KEY (SenderEmail) REFERENCES User(Email),
    FOREIGN KEY (ReceiverEmail) REFERENCES User(Email),
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID)
);
CREATE TABLE Vote (
    VoteID INT PRIMARY KEY,
    Email VARCHAR(255),
    ChapterID INT,
    DateTime DATETIME,
    FOREIGN KEY (Email) REFERENCES User(Email),
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID)
);

CREATE TABLE Comment (
    CommentID INT PRIMARY KEY,
    Email VARCHAR(255),
    ChapterID INT,
    CommentText TEXT,
    DateTime DATETIME,
    FOREIGN KEY (Email) REFERENCES User(Email),
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID)
);

CREATE TABLE ReportedContent (
    ReportID INT PRIMARY KEY,
    Email VARCHAR(255),
    ChapterID INT,
    CommentID INT,
    ReportDetails TEXT,
	Action VARCHAR(10),
    FOREIGN KEY (Email) REFERENCES User(Email),
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID),
    FOREIGN KEY (CommentID ) REFERENCES Comment(CommentID )
);


INSERT INTO User (Email, Username, Name, DOB, Password, Avatar, Signature, RegistrationDate, BackgroundTheme, Type, SecurityQuestion, SecurityQuestionAns)
VALUES
('john@example.com', 'john_doe', 'John Doe', '2014-05-15', 'hashed_password', 'avatar.jpg', 'Happiness is a journey, not a destination.', '2023-01-01', 'light', 'U', '1a', 'Blue'),
('jane@example.com', 'jane_smith', 'Jane Smith', '2010-08-22', 'hashed_password', 'profile_pic.png', 'Life is short, make it sweet.', '2023-01-05', 'dark', 'U', '1b', 'Fluffy'),
('sam@example.com', 'sam_Jim', 'Jime', '2014-05-15', 'hashed_password', 'avatar.jpg', 'Follow your dreams and never give up.', '2023-01-01', 'light', 'U', '1c', 'Blue'),
('kelvin@example.com', 'Kelvin', 'JK Smith', '2010-08-22', 'hashed_password', 'profile_pic.png', NULL, '2023-01-05', 'dark', 'U', '1d', 'Fluffy'),
('yane@example.com', 'Yane', 'Yane Doe', '2014-05-15', 'hashed_password', 'avatar.jpg', NULL, '2023-01-01', 'light', 'U', '1e', 'Blue'),
('sue@example.com', 'sue', 'Sue Smith', '2010-08-22', 'hashed_password', 'profile_pic.png', NULL, '2023-01-05', 'dark', 'U', '1a', 'Fluffy'),
('joanne@example.com', 'joanne12', 'Joanne', '2014-05-15', 'hashed_password', 'avatar.jpg', NULL, '2023-01-01', 'light', 'U', '1b', 'Blue'),
('lucy@example.com', 'lucyyy', 'Lucy Smith', '2010-08-22', 'hashed_password', 'profile_pic.png', NULL, '2023-01-05', 'dark', 'U', '1c', 'Fluffy');

INSERT INTO Genre (GenreID, GenreDetail)
VALUES
(11, 'Fantasy'),
(12, 'Science Fiction'),
(13, 'Mystery'),
(14, 'Adventure');

INSERT INTO Theme (ThemeID, ThemeDetail)
VALUES
(21, 'Relationship'),
(22, 'Modern'),
(23, 'Minimalistic'),
(24, 'Abstract'),
(25, 'Nature');

INSERT INTO Story (StoryID, Email, GenreID, ThemeID, Title, WordLimit, Access, CoverPage, Status, DateTime, ContributionLoop)
VALUES
(31, 'john@example.com', 11, 23, 'The Lost World', 500, 'PUB', 'lost_world_cover.jpg', 'F', '2024-02-19 08:00:00', 1),
(32, 'jane@example.com', 12, 22, 'Starship Odyssey', NULL, 'PVT', 'coverPage.jpg', 'F', '2023-02-12 10:30:00', NULL),
(33, 'john@example.com', 11, 23, 'The Lost World 2', 500, 'PUB', 'lost_world_cover.jpg', 'O', '2023-02-10 08:00:00', 1),
(34, 'jane@example.com', 12, 21, 'Starship Odyssey 2', NULL, 'PVT', 'coverPage.jpg', 'O', '2023-02-12 10:30:00', NULL),
(35, 'john@example.com', 13, 21, 'The Lost World 3', 500, 'PUB', 'lost_world_cover.jpg', 'O', '2023-02-10 08:00:00', 1),
(36, 'jane@example.com', 12, 22, 'Starship Odyssey 3', NULL, 'PVT', 'coverPage.jpg', 'O', '2023-02-12 10:30:00', NULL),
(37, 'john@example.com', 11, 23, 'story 1', 500, 'PUB', 'lost_world_cover.jpg', 'F', '2023-02-10 08:00:00', 1),
(38, 'jane@example.com', 12, 22, 'story 2', NULL, 'PVT', 'coverPage.jpg', 'F', '2023-02-12 10:30:00', NULL),
(39, 'john@example.com', 11, 23, 'story 3', 500, 'PUB', 'lost_world_cover.jpg', 'O', '2023-02-10 08:00:00', 1),
(310, 'jane@example.com', 12, 21, 'story 4', NULL, 'PVT', 'coverPage.jpg', 'O', '2023-02-12 10:30:00', NULL),
(311, 'john@example.com', 13, 25, 'story 5', 500, 'PUB', 'lost_world_cover.jpg', 'O', '2023-02-10 08:00:00', 1),
(312, 'jane@example.com', 12, 22, 'story 6', NULL, 'PVT', 'coverPage.jpg', 'O', '2023-02-12 10:30:00', NULL),
(313, 'john@example.com', 11, 23, 'story 7', 500, 'PUB', 'lost_world_cover.jpg', 'F', '2023-02-10 08:00:00', 1),
(314, 'jane@example.com', 12, 22, 'story 8', NULL, 'PVT', 'coverPage.jpg', 'F', '2023-02-12 10:30:00', NULL),
(315, 'john@example.com', 11, 24, 'story 9', 500, 'PUB', 'lost_world_cover.jpg', 'O', '2023-02-10 08:00:00', 1),
(316, 'jane@example.com', 12, 21, 'story 10', NULL, 'PVT', 'coverPage.jpg', 'O', '2023-02-12 10:30:00', NULL),
(317, 'john@example.com', 13, 23, 'story 11', 500, 'PUB', 'lost_world_cover.jpg', 'O', '2023-02-10 08:00:00', 1),
(320, 'lucy@example.com', 13, 23, 'My Father\'s Dragon', 500, 'PUB', 'My_Fathers_Dragon.jpg', 'O', '2024-02-12 08:00:00', 1),
(319, 'sue@example.com', 14, 23, 'The Velveteen Rabbit', NULL, 'PVT', 'The_Velveteen_Rabbit_pg_25.jpg', 'O', '2024-02-10 08:00:00', NULL),
(318, 'jane@example.com', 12, 22, 'story 12', NULL, 'PVT', 'coverPage.jpg', 'O', '2023-02-12 10:30:00', NULL);


INSERT INTO Chapter (ChapterID, Email, StoryID, ChapBeforeID, ChapterName, Content, WordCount, Status, DateTime, Ending)
VALUES
(41, 'john@example.com', 31, NULL, 'Chapter 1: The Beginning', 'Once upon a time...', 350, 'P', '2024-02-19 09:30:00', 0),
(42, 'jane@example.com', 32, NULL, 'Prologue', 'In the vastness of space...', 420, 'P', '2024-02-13 12:45:00', 0),
(43, 'john@example.com', 33, NULL, 'The Adventure Continues', 'After the thrilling events of the first book...', 300, 'P', '2024-02-11 09:15:00', 0),
(44, 'jane@example.com', 34, NULL, 'New Challenges', 'As the starship embarks on a new journey...', 380, 'P', '2023-02-13 14:20:00', 0),
(45, 'john@example.com', 35, NULL, 'The Final Confrontation', 'In the heart of the lost world...', 400, 'P', '2023-02-11 11:30:00', 1),
(46, 'jane@example.com', 36, NULL, 'Farewell', 'As the starship leaves the galaxy...', 350, 'P', '2023-02-13 16:00:00', 1),
(47, 'john@example.com', 37, NULL, 'Introduction', 'Once upon a time in a small town...', 320, 'P', '2023-02-11 10:00:00', 0),
(48, 'jane@example.com', 38, NULL, 'Mysterious Encounters', 'In the quiet village, strange things happen...', 380, 'P', '2023-02-13 15:00:00', 0),
(49, 'john@example.com', 39, NULL, 'Unraveling Secrets', 'As the protagonist dives deeper into the mystery...', 300, 'P', '2023-02-11 10:45:00', 0),
(410, 'jane@example.com', 310, NULL, 'Unexpected Twists', 'Just when you thought you knew...', 420, 'P', '2023-02-13 17:30:00', 0),
(411, 'john@example.com', 311, NULL, 'Epic Finale', 'The climax of the epic tale unfolds...', 400, 'P', '2023-02-11 12:45:00', 1),
(412, 'jane@example.com', 312, NULL, 'Epilogue', 'As the curtain falls...', 350, 'P', '2023-02-13 18:45:00', 1),
(413, 'john@example.com', 313, NULL, 'Beginnings', 'In a land far away...', 330, 'P', '2023-02-11 11:15:00', 0),
(414, 'jane@example.com', 314, NULL, 'Intriguing Events', 'The plot thickens as mysteries unfold...', 380, 'P', '2023-02-13 16:30:00', 0),
(415, 'john@example.com', 315, NULL, 'Revelations', 'The truth is revealed in unexpected ways...', 320, 'P', '2023-02-11 12:00:00', 1),
(416, 'jane@example.com', 316, NULL, 'Turning Points', 'Decisions that shape the course of the story...', 400, 'P', '2023-02-13 19:15:00', 1),
(417, 'john@example.com', 317, NULL, 'Journeys End', 'The characters reach the end of their quest...', 380, 'P', '2023-02-11 13:30:00', 1),
(425, 'sue@example.com', 319, NULL, 'The Beginning', 'There was once a velveteen rabbit, and in the beginning he was really splendid. He was fat and bunchy, as a rabbit should be; his coat was spotted brown and white, he had real thread whiskers, and his ears were lined with pink sateen. On Christmas morning, when he sat wedged in the top of the Boy’s stocking, with a sprig of holly between his paws, the effect was charming.

There were other things in the stocking, nuts and oranges and a toy engine, and chocolate almonds and a clockwork mouse, but the Rabbit was quite the best of all. For at least two hours the Boy loved him, and then Aunts and Uncles came to dinner, and there was a great rustling of tissue paper and unwrapping of parcels, and in the excitement of looking at all the new presents the Velveteen Rabbit was forgotten.

For a long time he lived in the toy cupboard or on the nursery floor, and no one thought very much about him. He was naturally shy, and being only made of velveteen, some of the more expensive toys quite snubbed him. The mechanical toys were very superior, and looked down upon every one else; they were full of modern ideas, and pretended they were real. The model boat, who had lived through two seasons and lost most of his paint, caught the tone from them and never missed an opportunity of referring to his rigging in technical terms. The Rabbit could not claim to be a model of anything, for he didn’t know that real rabbits existed; he thought they were all stuffed with sawdust like himself, and he understood that sawdust was quite out-of-date and should never be mentioned in modern circles. Even Timothy, the jointed wooden lion, who was made by the disabled soldiers, and should have had broader views, put on airs and pretended he was connected with Government. Between them all the poor little Rabbit was made to feel himself very insignificant and commonplace, and the only person who was kind to him at all was the Skin Horse.', 380, 'P', '2024-02-20 13:30:00', 1),
(418, 'jane@example.com', 318, NULL, 'The Grand Finale', 'All loose ends are tied up in the final chapter...', 420, 'D', '2023-02-13 20:30:00', 1),
(427, 'lucy@example.com', 320, NULL, 'MY FATHER MEETS THE CAT', 'One cold rainy day when my father was a little boy, he met an old alley cat on his street. The cat was very drippy and uncomfortable so my father said, "Wouldn\'t you like to come home with me?"

This surprised the cat—she had never before met anyone who cared about old alley cats—but she said, "I\'d be very much obliged if I could sit by a warm furnace, and perhaps have a saucer of milk."

"We have a very nice furnace to sit by," said my father, "and I\'m sure my mother has an extra saucer of milk. My father and the cat became good friends but my father\'s mother was very upset about the cat. She hated cats, particularly ugly old alley cats. "Elmer Elevator," she said to my father, "if you think I\'m going to give that cat a saucer of milk, you\'re very wrong. Once you start feeding stray alley cats you might as well expect to feed every stray in town, and I am not going to do it!"

This made my father very sad, and he apologized to the cat because his mother had been so rude. He told the cat to stay anyway, and that somehow he would bring her a saucer of milk each day. My father fed the cat for three weeks, but one day his mother found the cat\'s saucer in the cellar and she was extremely angry. She whipped my father and threw the cat out the door, but later on my father sneaked out and found the cat. Together they went for a walk in the park and tried to think of nice things to talk about. My father said, "When I grow up I\'m going to have an airplane. Wouldn\'t it be wonderful to fly just anywhere you might think of!"

"Would you like to fly very, very much?" asked the cat.

"I certainly would. I\'d do anything if I could fly." "Well," said the cat, "If you\'d really like to fly that much, I think I know of a sort of a way you might get to fly while you\'re still a little boy."

"You mean you know where I could get an airplane?"

"Well, not exactly an airplane, but something even better. As you can see, I\'m an old cat now, but in my younger days I was quite a traveler. My traveling days are over but last spring I took just one more trip and sailed to the Island of Tangerina, stopping at the port of Cranberry. Well, it just so happened that I missed the boat, and while waiting for the next I thought I\'d look around a bit. I was particularly interested in a place called Wild Island, which we had passed on our way to Tangerina. Wild Island and Tangerina are joined together by a long string of rocks, but people never go to Wild Island because it\'s mostly jungle and inhabited by very wild animals. So, I decided to go across the rocks and explore it for myself. It certainly is an interesting place, but I saw something there that made me want to weep."', 420, 'D', '2023-02-18 20:30:00', 1);

INSERT INTO Chapter (ChapterID, Email, StoryID, ChapBeforeID, ChapterName, Content, WordCount, Status, DateTime, Ending)
VALUES
(419, 'john@example.com', 31, 41, 'Chapter 2: The Journeys', 'Once upon a time...', 350, 'P', '2024-02-19 09:30:00', 0),
(420, 'jane@example.com', 32, 42, 'Prologue', 'In the vastness of space...', 420, 'P', '2024-02-13 12:45:00', 0),
(428, 'jane@example.com', 320, 427, 'MY FATHER RUNS AWAY', '"Wild Island is practically cut in two by a very wide and muddy river," continued the cat. "This river begins near one end of the island and flows into the ocean at the other. Now the animals there are very lazy, and they used to hate having to go all the way around the beginning of this river to get to the other side of the island. It made visiting inconvenient and mail deliveries slow, particularly during the Christmas rush. Crocodiles could have carried passengers and mail across the river, but crocodiles are very moody, and not the least bit dependable, and are always looking for something to eat. They don\'t care if the animals have to walk around the river, so that\'s just what the animals did for many years."

"But what does all this have to do with airplanes?" asked my father, who thought the cat was taking an awfully long time to explain.

"Be patient, Elmer," said the cat, and she went on with the story. "One day about four months before I arrived on Wild Island a baby dragon fell from a low-flying cloud onto the bank of the river. He was too young to fly very well, and besides, he had bruised one wing quite badly, so he couldn\'t get back to his cloud. The animals found him soon afterwards and everybody said, \'Why, this is just exactly what we\'ve needed all these years!\' They tied a big rope around his neck and waited for the wing to get well. This was going to end all their crossing-the-river troubles." 
"I\'ve never seen a dragon," said my father. "Did you see him? How big is he?"

"Oh, yes, indeed I saw the dragon. In fact, we became great friends," said the cat. "I used to hide in the bushes and talk to him when nobody was around. He\'s not a very big dragon, about the size of a large black bear, although I imagine he\'s grown quite a bit since I left. He\'s got a long tail and yellow and blue stripes. His horn and eyes and the bottoms of his feet are bright red, and he has gold-colored wings."

"Oh, how wonderful!" said my father. "What did the animals do with him when his wing got well?"

"They started training him to carry passengers, and even though he is just a baby dragon, they work him all day and all night too sometimes. They make him carry loads that are much too heavy, and if he complains, they twist his wings and beat him. He\'s always tied to a stake on a rope just long enough to go across the river. His only friends are the crocodiles, who say \'Hello\' to him once a week if they don\'t forget. Really, he\'s the most miserable animal I\'ve ever come across. When I left I promised I\'d try to help him someday, although I couldn\'t see how. The rope around his neck is about the biggest, toughest rope you can imagine, with so many knots it would take days to untie them all.

"Anyway, when you were talking about airplanes, you gave me a good idea. Now, I\'m quite sure that if you were able to rescue the dragon, which wouldn\'t be the least bit easy, he\'d let you ride him most anywhere, provided you were nice to him, of course. How about trying it?"

"Oh, I\'d love to," said my father, and he was so angry at his mother for being rude to the cat that he didn\'t feel the least bit sad about running away from home for a while.

That very afternoon my father and the cat went down to the docks to see about ships going to the Island of Tangerina. They found out that a ship would be sailing the next week, so right away they started planning for the rescue of the dragon. The cat was a great help in suggesting things for my father to take with him, and she told him everything she knew about Wild Island. Of course, she was too old to go along.

Everything had to be kept very secret, so when they found or bought anything to take on the trip they hid it behind a rock in the park. The night before my father sailed he borrowed his father\'s knapsack and he and the cat packed everything very carefully. He took chewing gum, two dozen pink lollipops, a package of rubber bands, black rubber boots, a compass, a tooth brush and a tube of tooth paste, six magnifying glasses, a very sharp jackknife, a comb and a hairbrush, seven hair ribbons of different colors, an empty grain bag with a label saying "Cranberry," some clean clothes, and enough food to last my father while he was on the ship. He couldn\'t live on mice, so he took twenty-five peanut butter and jelly sandwiches and six apples, because that\'s all the apples he could find in the pantry.

When everything was packed my father and the cat went down to the docks to the ship. A night watchman was on duty, so while the cat made loud queer noises to distract his attention, my father ran over the gang-plank onto the ship. He went down into the hold and hid among some bags of wheat. The ship sailed early the next morning.', 420, 'P', '2024-02-20 12:45:00', 1),
(429, 'sam@example.com', 320, 427, 'MY FATHER FINDS THE ISLAND', 'My father hid in the hold for six days and nights. Twice he was nearly caught when the ship stopped to take on more cargo. But at last he heard a sailor say that the next port would be Cranberry and that they\'d be unloading the wheat there. My father knew that the sailors would send him home if they caught him, so he looked in his knapsack and took out a rubber band and the empty grain bag with the label saying "Cranberry." At the last moment my father got inside the bag, knapsack and all, folded the top of the bag inside, and put the rubber band around the top. He didn\'t look just exactly like the other bags but it was the best he could do.

Soon the sailors came to unload. They lowered a big net into the hold and began moving the bags of wheat. Suddenly one sailor yelled, "Great Scott! This is the queerest bag of wheat I\'ve ever seen! It\'s all lumpy-like, but the label says it\'s to go to Cranberry."

The other sailors looked at the bag too, and my father, who was in the bag, of course, tried even harder to look like a bag of wheat. Then another sailor felt the bag and he just happened to get hold of my father\'s elbow. "I know what this is," he said. "This is a bag of dried corn on the cob," and he dumped my father into the big net along with the bags of wheat.

This all happened in the late afternoon, so late that the merchant in Cranberry who had ordered the wheat didn\'t count his bags until the next morning. (He was a very punctual man, and never late for dinner.) The sailors told the captain, and the captain wrote down on a piece of paper, that they had delivered one hundred and sixty bags of wheat and one bag of dried corn on the cob. They left the piece of paper for the merchant and sailed away that evening.

My father heard later that the merchant spent the whole next day counting and recounting the bags and feeling each one trying to find the bag of dried corn on the cob. He never found it because as soon as it was dark my father climbed out of the bag, folded it up and put it back in his knapsack. He walked along the shore to a nice sandy place and lay down to sleep.', 300, 'P', '2024-02-19 09:15:00', 0),
(430, 'sam@example.com', 320, 427, 'MY FATHER', 'My father hid in the hold for six days and nights. Twice he was nearly caught when the ship stopped to take on more cargo. But at last he heard a sailor say that the next port would be Cranberry and that they\'d be unloading the wheat there. My father knew that the sailors would send him home if they caught him, so he looked in his knapsack and took out a rubber band and the empty grain bag with the label saying "Cranberry." At the last moment my father got inside the bag, knapsack and all, folded the top of the bag inside, and put the rubber band around the top. He didn\'t look just exactly like the other bags but it was the best he could do. My father heard later that the merchant spent the whole next day counting and recounting the bags and feeling each one trying to find the bag of dried corn on the cob. He never found it because as soon as it was dark my father climbed out of the bag, folded it up and put it back in his knapsack. He walked along the shore to a nice sandy place and lay down to sleep.', 300, 'P', '2024-02-20 09:15:00', 0),
(421, 'sam@example.com', 33, 41, 'The Adventure Continues', 'After the thrilling events of the first book...', 300, 'P', '2024-02-11 09:15:00', 0),
(426, 'sue@example.com', 319, 425, 'The Adventure Continues', 'The Skin Horse had lived longer in the nursery than any of the others. He was so old that his brown coat was bald in patches and showed the seams underneath, and most of the hairs in his tail had been pulled out to string bead necklaces. He was wise, for he had seen a long succession of mechanical toys arrive to boast and swagger, and by-and-by break their mainsprings and pass away, and he knew that they were only toys, and would never turn into anything else. For nursery magic is very strange and wonderful, and only those playthings that are old and wise and experienced like the Skin Horse understand all about it.

"What is REAL?" asked the Rabbit one day, when they were lying side by side near the nursery fender, before Nana came to tidy the room. "Does it mean having things that buzz inside you and a stick-out handle?"

"Real isn\'t how you are made," said the Skin Horse. "It\'s a thing that happens to you. When a child loves you for a long, long time, not just to play with, but REALLY loves you, then you become Real."

"Does it hurt?" asked the Rabbit.

"Sometimes," said the Skin Horse, for he was always truthful. "When you are Real you don\'t mind being hurt."

"Does it happen all at once, like being wound up," he asked, "or bit by bit?"

"It doesn\'t happen all at once," said the Skin Horse. "You become. It takes a long time. That\'s why it doesn\'t often happen to people who break easily, or have sharp edges, or who have to be carefully kept. Generally, by the time you are Real, most of your hair has been loved off and your eyes drop out and you get loose in the joints and very shabby. But these things don\'t matter at all, because once you are Real you can\'t be ugly, except to people who don\'t understand."

"I suppose you are Real?" said the Rabbit. And then he wished he had not said it, for he thought the Skin Horse might be sensitive. But the Skin Horse only smiled.

"The Boy\'s Uncle made me Real," he said. "That was a great many years ago; but once you are Real you can\'t become unreal again. It lasts for always."

The Rabbit sighed. He thought it would be a long time before this magic called Real happened to him. He longed to become Real, to know what it felt like; and yet the idea of growing shabby and losing his eyes and whiskers was rather sad. He wished that he could become it without these uncomfortable things happening to him.

There was a person called Nana who ruled the nursery. Sometimes she took no notice of the playthings lying about, and sometimes, for no reason whatever, she went swooping about like a great wind and hustled them away in cupboards. She called this "tidying up," and the playthings all hated it, especially the tin ones. The Rabbit didn\'t mind it so much, for wherever he was thrown he came down soft.

One evening, when the Boy was going to bed, he couldn\'t find the china dog that always slept with him. Nana was in a hurry, and it was too much trouble to hunt for china dogs at bedtime, so she simply looked about her, and seeing that the toy cupboard door stood open, she made a swoop.

"Here," she said, "take your old Bunny! He\'ll do to sleep with you!" And she dragged the Rabbit out by one ear, and put him into the Boy\'s arms.

That night, and for many nights after, the Velveteen Rabbit slept in the Boy’s bed. At first he found it rather uncomfortable, for the Boy hugged him very tight, and sometimes he rolled over on him, and sometimes he pushed him so far under the pillow that the Rabbit could scarcely breathe. And he missed, too, those long moonlight hours in the nursery, when all the house was silent, and his talks with the Skin Horse. But very soon he grew to like it, for the Boy used to talk to him, and made nice tunnels for him under the bedclothes that he said were like the burrows the real rabbits lived in. And they had splendid games together, in whispers, when Nana had gone away to her supper and left the nightlight burning on the mantelpiece. And when the Boy dropped off to sleep, the Rabbit would snuggle down close under his little warm chin and dream, with the Boy\'s hands clasped close round him all night long.

And so time went on, and the little Rabbit was very happy—so happy that he never noticed how his beautiful velveteen fur was getting shabbier and shabbier, and his tail coming unsewn, and all the pink rubbed off his nose where the Boy had kissed him.', 300, 'P', '2024-02-21 09:15:00', 0);

INSERT INTO Chapter (ChapterID, Email, StoryID, ChapBeforeID, ChapterName, Content, WordCount, Status, DateTime, Ending)
VALUES
(422, 'sue@example.com', 319, 426, 'Spring Came', 'Spring came, and they had long days in the garden, for wherever the Boy went the Rabbit went too. He had rides in the wheelbarrow, and picnics on the grass, and lovely fairy huts built for him under the raspberry canes behind the flower border. And once, when the Boy was called away suddenly to go out to tea, the Rabbit was left out on the lawn until long after dusk, and Nana had to come and look for him with the candle because the Boy couldn’t go to sleep unless he was there. He was wet through with the dew and quite earthy from diving into the burrows the Boy had made for him in the flower bed, and Nana grumbled as she rubbed him off with a corner of her apron.
"You must have your old Bunny!" she said. "Fancy all that fuss for a toy!"

The Boy sat up in bed and stretched out his hands.

"Give me my Bunny!" he said. "You mustn\'t say that. He isn’t a toy. He’s REAL!"

When the little Rabbit heard that he was happy, for he knew that what the Skin Horse had said was true at last. The nursery magic had happened to him, and he was a toy no longer. He was Real. The Boy himself had said it.

That night he was almost too happy to sleep, and so much love stirred in his little sawdust heart that it almost burst. And into his boot-button eyes, that had long ago lost their polish, there came a look of wisdom and beauty, so that even Nana noticed it next morning when she picked him up, and said, "I declare if that old Bunny hasn\'t got quite a knowing expression!"


That was a wonderful Summer!

Near the house where they lived there was a wood, and in the long June evenings the Boy liked to go there after tea to play. He took the Velveteen Rabbit with him, and before he wandered off to pick flowers, or play at brigands among the trees, he always made the Rabbit a little nest somewhere among the bracken, where he would be quite cosy, for he was a kind-hearted little boy and he liked Bunny to be comfortable. One evening, while the Rabbit was lying there alone, watching the ants that ran to and fro between his velvet paws in the grass, he saw two strange beings creep out of the tall bracken near him.', 350, 'P', '2024-02-19 09:30:00', 0),
(423, 'jane@example.com', 32, 42, 'Prologue', 'In the vastness of space...', 420, 'P', '2024-02-13 12:45:00', 0),
(432, 'jane@example.com', 320, 428, 'MY FATHER FINDS THE DRAGON', 'The jungle began just beyond a narrow strip of beach; thick, dark, damp, scary jungle. My father hardly knew where to go, so he crawled under a wahoo bush to think, and ate eight tangerines. The first thing to do, he decided, was to find the river, because the dragon was tied somewhere along its bank. Then he thought, "If the river flows into the ocean, I ought to be able to find it quite easily if I just walk along the beach far enough." So my father walked until the sun rose and he was quite far from the Ocean Rocks. It was dangerous to stay near them because they might be guarded in the daytime. He found a clump of tall grass and sat down. Then he took off his rubber boots and ate three more tangerines. He could have eaten twelve but he hadn\'t seen any tangerines on this island and he could not risk running out of something to eat.

My father slept all that day and only woke up late in the afternoon when he heard a funny little voice saying, "Queer, queer, what a dear little dock! I mean, dear, dear, what a queer little rock!" My father saw a tiny paw rubbing itself on his knapsack. He lay very still and the mouse, for it was a mouse, hurried away muttering to itself, "I must smell tumduddy. I mean, I must tell somebody."', 420, 'P', '2024-03-01 12:45:00', 1),
(433, 'sam@example.com', 320, 428, 'MY FATHER FINDS THE DANJUN', 'The jungle began just beyond a narrow strip of beach; thick, dark, damp, scary jungle. My father hardly knew where to go, so he crawled under a wahoo bush to think, and ate eight tangerines. The first thing to do, he decided, was to find the river, because the dragon was tied somewhere along its bank. Then he thought, "If the river flows into the ocean, I ought to be able to find it quite easily if I just walk along the beach far enough." So my father walked until the sun rose and he was quite far from the Ocean Rocks. It was dangerous to stay near them because they might be guarded in the daytime. He found a clump of tall grass and sat down. Then he took off his rubber boots and ate three more tangerines. He could have eaten twelve but he hadn\'t seen any tangerines on this island and he could not risk running out of something to eat.

My father slept all that day and only woke up late in the afternoon when he heard a funny little voice saying, "Queer, queer, what a dear little dock! I mean, dear, dear, what a queer little rock!" My father saw a tiny paw rubbing itself on his knapsack. He lay very still and the mouse, for it was a mouse, hurried away muttering to itself, "I must smell tumduddy. I mean, I must tell somebody."', 420, 'P', '2024-03-02 12:45:00', 1),
(431, 'joanne@example.com', 320, 428, 'MY FATHER FINDS THE RIVER', 'The jungle began just beyond a narrow strip of beach; thick, dark, damp, scary jungle. My father hardly knew where to go, so he crawled under a wahoo bush to think, and ate eight tangerines. The first thing to do, he decided, was to find the river, because the dragon was tied somewhere along its bank. Then he thought, "If the river flows into the ocean, I ought to be able to find it quite easily if I just walk along the beach far enough." So my father walked until the sun rose and he was quite far from the Ocean Rocks. It was dangerous to stay near them because they might be guarded in the daytime. He found a clump of tall grass and sat down. Then he took off his rubber boots and ate three more tangerines. He could have eaten twelve but he hadn\'t seen any tangerines on this island and he could not risk running out of something to eat.

My father slept all that day and only woke up late in the afternoon when he heard a funny little voice saying, "Queer, queer, what a dear little dock! I mean, dear, dear, what a queer little rock!" My father saw a tiny paw rubbing itself on his knapsack. He lay very still and the mouse, for it was a mouse, hurried away muttering to itself, "I must smell tumduddy. I mean, I must tell somebody."', 420, 'P', '2024-02-28 12:45:00', 0),
(424, 'sam@example.com', 33, 41, 'The Adventure Continues', 'After the thrilling events of the first book...', 300, 'P', '2024-02-11 09:15:00', 0);

INSERT INTO Comment (CommentID, Email, ChapterID, CommentText, DateTime)
VALUES
(51, 'sam@example.com', 410, 'Great chapter!', '2023-03-12 10:50:00'),
(52, 'kelvin@example.com', 410, 'I enjoyed reading this.', '2023-03-12 11:05:00'),
(53, 'yane@example.com', 411, 'Nice story development.', '2023-12-11 10:30:00'),
(54, 'sue@example.com', 411, 'Exciting plot twists!', '2023-12-11 10:45:00'),
(55, 'joanne@example.com', 412, 'Can\'t wait for the next chapter!', '2023-10-12 11:15:00'),
(56, 'lucy@example.com', 413, 'Intriguing storyline.', '2023-09-12 11:30:00'),
(57, 'sam@example.com', 414, 'Another exciting chapter!', '2024-01-11 10:45:00'),
(58, 'kelvin@example.com', 415, 'I like the character development.', '2023-03-12 12:00:00'),
(59, 'yane@example.com', 416, 'Thrilling climax!', '2024-10-12 11:30:00'),
(510, 'sue@example.com', 417, 'Great storytelling!', '2023-12-11 12:15:00');

INSERT INTO Invitation (InvitationID, SenderEmail, ReceiverEmail, ChapterID)
VALUES
(71, 'sue@example.com', 'kelvin@example.com', 422),
(72, 'jane@example.com', 'joanne@example.com', 428);

INSERT INTO Vote (VoteID, Email, ChapterID, DateTime)
VALUES
(61, 'sam@example.com', 428, '2023-02-12 12:30:00'),
(62, 'kelvin@example.com', 428, '2023-02-12 13:15:00'),
(63, 'yane@example.com', 429, '2023-02-12 14:00:00'),
(64, 'sue@example.com', 429, '2023-02-12 15:45:00'),
(65, 'joanne@example.com', 428, '2023-02-12 16:30:00'),
(66, 'lucy@example.com', 430, '2023-02-12 17:15:00'),
(67, 'sam@example.com', 429, '2023-02-12 18:00:00'),
(68, 'kelvin@example.com', 429, '2023-02-12 19:45:00'),
(69, 'yane@example.com', 429, '2023-02-12 20:30:00'),
(610, 'sue@example.com', 430, '2023-02-12 21:15:00');



INSERT INTO Vote (VoteID, Email, ChapterID, DateTime)
VALUES
(611, 'sam@example.com', 432, '2023-02-12 12:30:00'),
(612, 'kelvin@example.com', 432, '2023-02-12 13:15:00'),
(613, 'yane@example.com', 432, '2023-02-12 14:00:00'),
(614, 'sue@example.com', 433, '2023-02-12 15:45:00'),
(615, 'joanne@example.com', 435, '2023-02-12 16:30:00'),
(616, 'lucy@example.com', 435, '2023-02-12 17:15:00'),
(617, 'sam@example.com', 436, '2023-02-12 18:00:00'),
(618, 'kelvin@example.com', 436, '2023-02-12 19:45:00'),
(619, 'yane@example.com', 436, '2023-02-12 20:30:00'),
(620, 'sue@example.com', 435, '2023-02-12 21:15:00');