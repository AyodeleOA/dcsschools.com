<?php
require_once __DIR__ . '/db.php';

$pdo = db();

echo "Seeding academic cards...\n";

$cards = [
    [
        'title' => 'Nursery School',
        'description' => "The Nursery School at Divine Confidence School provides a warm, safe, and well-structured environment where young children are gently introduced to formal education. Learning at this stage is engaging and enjoyable, helping children develop curiosity, confidence, and a positive attitude toward school. Great emphasis is placed on character formation, emotional development, and building healthy social relationships.\n\nThe curriculum focuses on early literacy and numeracy, communication and language development, creativity, and social interaction. Through play-based and activity-driven learning, children are exposed to letters, sounds, numbers, shapes, colours, and basic writing skills in age-appropriate ways. Songs, storytelling, games, and hands-on exploration are carefully planned to support cognitive, physical, and emotional growth. Moral and faith-based instruction is intentionally integrated into daily routines, guiding children to develop good manners, respect, obedience, and confidence from an early age.\n\nAssessment at the nursery level is continuous, developmental, and formative. Teachers closely observe each child’s progress to understand individual strengths, learning pace, and areas needing support. This approach ensures that pupils are not pressured, but are carefully guided and well prepared both academically and socially for a smooth transition into primary education.",
        'image_path_1' => 'assets/images/nur1.png',
        'image_path_2' => 'assets/images/nur2.png',
        'sort_order' => 1
    ],
    [
        'title' => 'Primary School',
        'description' => "The Primary School programme at Divine Confidence School builds deliberately on the foundation laid at the nursery level, providing pupils with a strong academic, moral, and social base. Teaching at this stage is carefully structured to strengthen literacy and numeracy, develop logical reasoning, and encourage creativity, while also fostering independence, confidence, and responsible behaviour.\n\nPupils are taught a broad range of core subjects drawn from the Nigerian and British curricula, ensuring balanced and comprehensive academic exposure. Lessons are interactive and activity-driven, encouraging pupils to ask questions, think critically, and apply what they learn across subjects. Alongside academics, strong emphasis is placed on discipline, respect, leadership, teamwork, and effective communication, supported by consistent moral and faith-based instruction.\n\nAs pupils advance through the primary level, they are gradually guided toward higher academic expectations and accountability. Preparation is structured to equip them for nationally and internationally recognised assessments, including the Basic Education Certificate Examination (BECE – NECO version) and the Cambridge Checkpoint Examinations. These assessments serve as important benchmarks, helping to measure academic progress and ensuring that pupils are well prepared, confident, and ready for a smooth transition into secondary education.",
        'image_path_1' => 'assets/images/pri1.png',
        'image_path_2' => 'assets/images/pri2.png',
        'sort_order' => 2
    ],
    [
        'title' => 'Secondary School (Divine Confidence College)',
        'description' => "Divine Confidence College is the secondary arm of Divine Confidence Nursery and Primary School, established to provide deeper academic, spiritual, and personal development for students as they transition into young adulthood. Built on a strong foundation of proven success at the earlier levels, the College exists to nurture students who are intellectually capable, morally upright, and prepared to face future academic and life challenges with confidence.\n\nAs a Christian-based, co-educational institution, Divine Confidence College places strong emphasis on Christian values and practices as an integral part of daily school life. Students are guided through consistent spiritual and moral mentorship that reinforces integrity, responsibility, discipline, respect for others, and leadership. These values shape not only academic conduct, but also character and decision-making beyond the classroom.\n\nThe secondary curriculum combines the strengths of the Nigerian and British educational standards, offering students a well-rounded and globally relevant learning experience. Through this blended approach, students develop critical and analytical thinking, scientific and mathematical reasoning, effective communication, and strong independent study habits. Teaching is structured to encourage inquiry, problem-solving, and academic depth, preparing students for higher levels of learning.\n\nAs students progress to the senior level, they are systematically prepared for major national and international examinations, including the West African Senior School Certificate Examination, the National Examination Council Examination, and the International General Certificate of Secondary Education (IGCSE). This structured preparation ensures that students are academically competitive and well positioned for further education within Nigeria and internationally.\n\nBeyond academics, Divine Confidence College is intentional about equipping students with essential soft skills such as adaptability, confidence, teamwork, and leadership. Students are encouraged to take responsibility for their learning, engage positively with their environment, and develop the resilience required to thrive in diverse settings. Admission into the College is open to students of all backgrounds, religions, and races, within a disciplined, inclusive, and supportive learning community.",
        'image_path_1' => 'assets/images/sec1.png',
        'image_path_2' => 'assets/images/sec2.png',
        'sort_order' => 3
    ]
];

// Clear existing cards to avoid duplicates (optional, based on requirement)
$pdo->exec("TRUNCATE TABLE academic_cards");

$stmt = $pdo->prepare("INSERT INTO academic_cards (title, description, image_path_1, image_path_2, sort_order) VALUES (?, ?, ?, ?, ?)");

foreach ($cards as $card) {
    $stmt->execute([
        $card['title'],
        $card['description'],
        $card['image_path_1'],
        $card['image_path_2'],
        $card['sort_order']
    ]);
    echo "Inserted: " . $card['title'] . "\n";
}

echo "Done.\n";
