<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        
        // Create an admin account to login
        // easily without having to harass with always
        // having to manually register
        DB::table('users')->insert([
        'name' => "admin",
        'email' => 'test@example.com',
        'password' => bcrypt('admin')]);
        
        DB::table('notes')->insert([
        	'title' => 'Eine erste Test-Notiz',
        	'content' => '# Eine Überschrift
        	
        	Mit einem Zeilenumbruch
        	
        	> und einem Blockquote'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Eine weitere Notiz',
        	'content' => '# Heading 1
        	
        	Mit einem `Zeilenumbruch`
        	
        	> und einem Blockquote'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Noch eine, weil es so schön ist',
        	'content' => '> Diesmal keine Überschrift
        	
        	Dafür ganz viel `Spaß`.'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Numero quatro',
        	'content' => '> Diesmal nur mit `Blockquote`'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Mambo number five',
        	'content' => '## Gedanken
        	
        	Das war wirklich eines der schlimmeren Lieder der 90er...'
        ]);
        
        DB::table('notes')->insert([
        	'title' => 'Autonomismus & Feminismus: "Wages for Housework"',
        	'content' => '- Grundtext: The Power of women and the subversion of the COmmunity (James & Dalla Costa 1973). Analysiert Familie als "soziale Fabrik", dh Familie als Teil kapitalistischer Entwicklung. *Hausarbeit ist essentiel um Surplus Value zu produzieren* (James & Dalla Costa 1973, 30-1) Grundidee, so Weeks, des Begriffs *"social factory"* ist, dass auch Gesellschaft und Gemeinschaft in Kapitalistischen Beziehungen verstrickt sind. (Weeks 2011, 121) Costa & James nutzen Begriff um zeigen, wie Haushalt und Sphäre bezahlter Arbeit zusammenhängen. Zentral ist Lohnarbeit, welche beide Sphären verbindet.

> As Dalla Costa and James explain it, the institution of the family serves as an important though obscured component of the wage system; as a social relation of the waged to the unwaged (12), it is an expansive category that includes "the unemployed, the old, the ill, children, and housewives"? (James 1976, 7). The family functions in this sense as a distributive mechanism through which wages can be imagined to extend to the nonwaged, underwaged, not-yet-waged, and no-longer-waged. As a privatized machine of social reproduction, the family serves to keep wages lower and hours longer than they would be if the general as sumption were that individuals needed either to be able to secure com modified equivalents to the goods and services produced within private households or to have enough time outside of waged work to produce the goods and services themselves. (Weeks 2011,121)

Familie liefert zudem ideologischen Grundlage, auf welcher sich Staat und Kapital rausreden können, die Kosten für soziale Reproduktion tragen zu müssen (Weeks 2011,121)

- WfH offenbart, dass nicht nur die normalen Arbeiter via Lohnsystem diszipliniert werden (Weeks 2011, 122).

# WfH & Refusal of Work


> calling domestic labor "work"? was not meant to elevate it but was imagined rather as "the first step towards refusing to do it"? (Federici 1995,191). Seeking paid work was not a viable way to refuse domestic work: "Slavery to an assembly line is not a liberation from slavery to a kitchen sink"? (James & Dalla Costa 1973, 33). (...) (Weeks 2011, 124)


> We must, Dalla Costa urges, "re fuse the myth of liberation through work"?—after all, "we have worked enough"? (47). (Weeks 2011, 124)


> "It is only from the capitalist viewpoint that being productive is a moral vir tue, not to say a moral imperative"? (Cox & Federici 1976, 6)

- ist nicht Refusal von Arbeit, sondern auch von zwei damals von Feministen vorgeschlagenen Alternativen, a) kommodifizierung von Hausarbeit und b) Sozialisierung derselben. `the feminists in the wages for housework movement rejected not only the capitalist but also the socialist remedies defended by other feminists at that time.` (Weeks 2011,125). 

# Kritiken an WfH

- Kapital hier zu monolitisch (als ob Kapital alleine Agenz hätte). Reduziert Agenz von Arbeitern. Angeblich determiniert Kapital die gesamte Familie etc (Weeks 2011, 127) Ist damit Kontra den autonomistischen Annahmen über Primat der Agenz auf seiten der Arbeiter
- Lohn für Hausarbeit würde Gendervision of Labor vertiefen (Weeks 2011,137)
- würde das Lohnsystem erhalten und nicht herausforern

# WfHs Forderungen als "Perspektiven"


> In two footnotes to the text, the demand for wages receives a still rather tentative, but certainly more positive endorsement. It should be read, Dalla Costa suggests in these notes, not only as a demand, but also as a perspective. (Weeks 2011, 128)


> As a perspective, it is not only a matter of the content of the demand, but of what it is that "we are saying"? when "we demand to be paid"? (Edmond and Fleming 1975, 7), (Weeks 2011, 128)

- WfH *demystifiziert* Diskurse über Familie & Arbeit, vorallem attackiert es scharfe Trennung der Sphären von Arbeit u. Familie. (`By naming part of what happens in the family as work, the demand for wages confounds the division between work as a site of coercion and regimentation and the family as a freely invented site of authentic and purely voluntary relations.` (Weeks 2011,129)). Familie als Job, der wie jeder andere Job bezahlt werden sollte und dementsprechend auch abgelehnt werden kann ((Power of Women Collective 1975, 87). 


> "we want to call work what is work so that eventually we might rediscover what is love and create what will be our sexuality which we have never known"? (Federici 1995,192).

- Weiterhin demystifiziert es, wie arbiträr Gesellschaftl. Produktion bewertet wird, nämlich via zuschreibung eines Lohns (oder halt keines Lohns) (Weeks 2011,129)
- Zudem wird dadurch die *Frauenrolle denaturalisiert*:


> "It is the demand by which our nature ends and our struggle begins because just to want wages for housework means to refuse that work as the expression of our nature, and therefore to refuse precisely the female role that capital has invented for us"? (Federici 1995,190). To demand a wage for a practice "so identi fied with being female"? is to begin a process of disidentification: "Even to ask for a wage is already to say that we are not that work"? (Edmond and Fleming 1975, 6). Thus, "to the degree that through struggle we gain the power to break our capitalist identification,"? women can, Cox and Federici claim, at least determine who it is that "we are not"? (Cox & Federici 1976, 8; emphasis added). (Weeks 2011,130)

- WfH auch als *cognitive mapping*, da es Beziehung zw. Produktion u Reproduktion aufzeigt. `cognitive mapping—that is, an attempt to construct "a situational representation on the part of the individual subject to that vaster and properly unrepresentable totality which is the ensemble of society’s structures as a whole"? (1991, 51).` (Weeks 2011, 130). So zB indem gezeigt wird, wie lang der *Arbeitstag* wirklich geht)


> "Up to now"? the demand’s supporters explain, "the working class, male and female, had its working day defined by capital—from punching in to punching out. That defined the time we belonged to capital and the time we belonged to ourselves."? "But,"? they continue, "we have never belonged to ourselves, we have always belonged to capital every moment of our lives. And it is time that we made capital pay for every moment of it"? (Cox & Federici 1976,12).15 (Weeks 2011,131)

# WfH als Provokation

- produziert feministisches Bewusstsein und Praxis. 


> The lective practice of demanding thus has its own epistemological and onto logical productivity. (Weeks 2011,131)

- WfH ist einmal Forderung nach Macht (via finanzieller UNabhängigkeit von Männern etc), gleichzeitig aber schafft es auch Macht: `"the autonomy that the wage and the struggle for the wage can bring"` (James 1975,18). Here we see more clearly the demand’s status as a means rather than an end. ˋ (Weeks 2011,133) So Schreiben James & Dalla Costa 1973 53, n17:


> Whether the canteen or the wages we win will be a victory or a defeat depends on the force of our struggle. On that force depends whether the goal is an occasion for capital to more rationally command our labor or an occasion for us to weaken their hold on that command. 

- in diesem Sinne war der konkrete Inhalt der Forderung weniger wichtig, als die Macht, welche der kampf um die Forderung generieren kann (Weeks 2011,134)
- Forderungen beziehen sich zudem weniger auf "Bedürfnisse", sondern erschaffen Begierden nach neuem. Es geht hier weniger drum eine Begierde zu stillen, als sie zu kultuvireren (Weeks 2011,135). Hiermit geht das hart *gegen den Linken Asketismus*


> "The left is horrified by the fact that workers—male and female, waged and unwaged—want more money, more time for themselves, more power, instead of being concerned with figuring out how to rationalise production"? (Cox & Federici 1976, 18)'
        ]);
     
        DB::table('notes')->insert([
            'title' => 'Psychologie & Ideologie. Naturalisierungsprozesse sozialer Ungleichheit. Positivismus',
            'content' => 'Zwei besonders beliebte Methoden zur Naturalisierung (oder besser gesagt Biologisierung) von sozialen Phänomenen sind Evolutionspsychologie & alles was mit Genetik zu tun hat.

Evolutionspsychologie wird von Hilary Rose als “a moral and intellectual cop-out" (2001:126) bezeichnet. EP nimmt an, dass "Human Nature" seit Jahrtausenden fix blieb. Aktuelle strukturelle Ungleichheiten (zB Klassenprivilegien oder das Patriarchat) sind nicht gesellschaftliche Kontingenzen, sondern biologisch in unserer "Natur" fixiert (ich erinner mich grad an Emma Goldmanns Zitat darüber, was die "menschl. Natur" doch aushalten musste, um den Status Quo zu rechtfertigen). 
Roberts zitiert auch Lucien Sève:
> **Turning economic contradictions into psychological problems is one of the standard tricks of bourgeois ideology.** (Lucien Sève)
Und weiter schreibt Roberts:
> With biology endorsed as destiny, arguments from evolutionary psychology have been used to argue against welfare provision, a position also favoured by some psycholo- gists who champion the so-called bio-psycho-social model of health. (Roberts 2015)
Und dasselbe gilt für Genetik (die ja sowieso gerne von Rechten zur Legitimierung herangezogen wird):
> Belief in the importance of genetic influences over environmental ones is of course a regular feature of right-wing political discourse. If there is something wrong then boiling everything down to genetics means that there is no need to change the environment. Any change required must take place in the people exposed to it. This is a message that psychology routinely reinforces. (Roberts 2015)


Das Muster ist dabei stets das gleiche und Psychologie ist stets handmaiden des Status Quo:
> psychology as a discipline takes our current alienated state as if it were a natural and unquestionable phenomenon. (Roberts 2015)

Klassischer lamer Positivismus, nimmt das Individuum als gegeben und projiziert es universalistisch in die Welt zurück. 

> Psychology appropriates human characteristics which are at least partly social and transfers these, both theoretically and practically, into the individual realm. (...) Firstly in transferring the characteristics of social networks and social groupings entirely to the realm of individuals, psychological ideas sweep away the reality of the social and bolster an individualised view of reality. Secondly presenting such knowledge as claimed scientific truths then obscures the ideological function of the former process of individual ‘acquisition’ and presents the claimed ideas as nuggets of pure truth.'
        ]);

        DB::table('notes')->insert([
            'title' => 'Neoliberalismus: Neuheiten. Finanzialisierung u. Governance [Foucault, Brown]',
            'content' => '* Brown listet einige Dinge auf, die sich im Gefüge des NL seit Foucault geändert haben oder dazugekommen sind. Zu den wichitgsten hierbei gehören imo:
1. Aufstieg des Finanzkapitals und dessen Finanzilisierung von allem. Dies verändert *"human capital from an ensemble of enterprises to a portfolio of investment"* Brown 2015:70)
2. Krisen durch Finanzkapitalismus. Nicht bloß Schulden- und Bankenkrisen, sondern vorallem wachsende Arbeitslosigkeit dadruch das der produktive Teil der Wirtschaft durch Finanzaktivitäten ersetzt wird.
3. Austerity politics und die mit dieser einhergehenden *"Opfer"*
4. Marketisierung u. Fianzialisierung des Staates, welches diesen furchtbar verletzlich macht
5. "Governance", d.h. die Vermischung der Lexika von Politik und Business
6. Das Bild des Bürgers als in Projekt der "wirtschaftlichen Gesundheit des Staates" integriert und mit diesem identifiziert. Somit kann der einzelne Bürger zum wohl der Bevölkerung geopfert werden.
7. Sekuritisierung
Brown 2015:70-72)'
        ]);

        DB::table('notes')->insert([
            'title' => 'Invisible Committee - Ontologische Asymmetrie des Insurgent',
            'content' => 'er Krieg des Insurgent gegen die Regierung muss asymmetrisch sein, weil diesem Konflikt selbst eine asymmetrische Ontologie zugrunde liegt, mit eigenen Methoden und Zielen. In diesem Konflikt ist der Insurgent sowohl Fokus als auch Ziel der Praktiken der Counter-Insurgency:
Er ist ersteinmal der Insurgent der ausgemerzt werden soll. Gleichzeitig ist er aber auch Teil der Bevölkerung, dessen Herz erobert werden soll. Während Counter-Insurgency sich einen Insurgent vorstellt, der eine heterogenes Element in der Bevölkerung darstellt, welches einfach identifiziert werden und von dieser getrennt werden kann, stellt der Insurgent aus der Sicht von IC kein heterogenes "radikales Subjekt" dar, welches dem sozialen Gefüge extern ist. Der Insurgent ist diesem vielmehr immanent, er ist ununterscheidbarer Teil desselben: 

> There is no one to be organized. We are that material which grows from within, which organizes itself and develops itself. The true asymmetry lies there, and our real position of strength is there. Those who make their belief into an article of export, through terror or performance, instead of dealing with what exists where they are, only cut themselves off from themselves and their base.'
        ]);

        DB::table('notes')->insert([
            'title' => 'Dronen: Nexus Topographie u. Fahndungstechnologien',
            'content' => '> Nexus Topography is an extension of the common practice of Social Network Analysis (SNA) used to develop profiles of HVIs. ... Nexus Topography maps social forums or environments, which bind individuals together."15 In this model *the enemy individual is no longer seen as a link in a hierarchical chain of command: he is a knot or "node" inserted into a number of social networks. Based on the concepts of "network-centric warfare" and "effectsbased operations," the idea is that by successfully targeting its key nodes, an enemy network can be disorganized to the point of being practically wiped out.* The masterminds of this methodology declare that "targeting a single key node in a battlefield system has second, third, n-order effects, and that these effects can be accurately calculated to ensure maximum success."16 This claim to predictive calculation is the foundation of the policy of prophylactic elimination, for which the hunter-killer drones are the main instruments. For the strategy of militarized manhunting is essentially preventive. **It is not so much a matter of responding to actual attacks but rather of preventing the development of emerging threats by the early elimination of their potential agents** — "to detect, deter, disrupt, detain or destroy networks before they can harm"17 — and to do this in the absence of any direct, imminent threat.18 (Chamayou 2015)'
        ]);

        DB::table('notes')->insert([
            'title' => 'Nihlismus - Geschichte. Bedeutung von N. im frühen 19. Jhd.',
            'content' => 'Kommt auf im Zuge der Diskussionen v. Kants Philosophie.
1787 schreibt ein J.H. Oberseite in Reihe von Pamphleten, dass aller Rationalismus inkl. und vor allem Kant Nihilismus sein, da sie Wissen auf Erscheinungen reduzieren. Laut Oberseite können wir nichts außerhalb unseres Bewusstseins wissen. Werte u. Moral haben somit keine rationale Basis (27-28). Beiser führt ihr Bonaventuras Nachtwachen als literarisches Beispiel an.
**Jacobi** wirft 1799 in Brief Fichte vor, dass Rationalismus in Solipsismus endet, was er auch Nihilismus nennt. Die externe Welt, andere Geister, Gott etc. werden angezweifelt. Nihilismus ist bei Jacobi nicht mehr nur moralisches Problem, sondern epistemologisches, da er Nihilismus mit Skeptizismus verknüpft. (28-29) Paradigmatisch der letzte Satz Humes.

> who at the close of the first book of the Treatise of Human Nature, famously declared that he could find no reason to believe in the existence of anything beyond his own passing impressions. (174) 
Jacobi ist der Ansicht, dass das Prinzip der Subjekt-Objekt Identität im Idealismus das Selbst in seinem eigenen Bewusstsein einsperrt . Laut diesem Prinzip weiß Selbst nur was es aus seinen eigenen Gesetzen produziert. Diese Aktivität ist a priori und Basis alles weiteren Wissens. Damit kommt es, laut Jacobi, nicht aus sich selbst heraus , da es nur eigene Kreationen kennt, nicht Realität, wie sie ohne diese ist (174-5). Kants Einwand wäre: Erscheinungen sind nicht nur Repräsentationen, da sie Erscheinungen von Dingen-in-sich-selbst sind. Aber Jacobi: Kant hat sich selbst verboten zu postulieren, dass es so etwas wie Dinge in-sich-selbst gibt, da sie außerhalb der Erfahrung sind. (175)'
        ]);

        DB::table('notes')->insert([
            'title' => 'Gesundheit als Ideologie: als Passiver Nihilismus',
            'content' => '* wie Cederström & Spicer argumentieren, führt das sog. Wellness-Syndrom zu einem Zustand, den Critchley "Passiven Nihilismus" nennt:
>  ‘Rather than acting in the world and trying to transform it the passive nihilist simply focuses on himself and his particular pleasures and projects for perfecting himself, whether through discovering the inner child, manipulating pyramids, writing pessimistic-sounding literary essays, taking up yoga, bird-watching or botany.’ (Simon Critchley, Infinitely Demanding: Ethics of Commitment, Politics of Resistance (London: Verso, 2007, p4)
* also ein totaler Rückzug von der Welt.
> Having no hope of improving their lives in any of the ways that matter, people have convinced themselves that what matters is psychic self-improvement: getting in touch with their feelings, eating health food, taking lessons in ballet or belly-dancing, immersing themselves in the wisdom of the East, jogging, learning how to ‘relate’, overcoming the ‘fear of pleasure’. (Christopher Lasch, The Culture of Narcissism: American Life in an Age of Diminished Expectations (New York: W.W. Norton, 1979) , p. 4.)'
        ]);

        DB::table('notes')->insert([
            'title' => 'Gesundheit: als Ideologie',
            'content' => '> Today, wellness has become a moral demand – about which we are constantly and tirelessly reminded.
* Wie C & S argumentieren ist Wellness-als-Ideologie Teil eines größeren kulturellen Phänomens, worin individuelle Selbstverantwortung fetischisiert wird, aus Gründen letztendlich der Selbstvermarktung: Nicht-Rauchen, so ihr Beispiel, nicht bl0ß um Kosten zu sparen oder gesünder zu leben, sondenr um den eigenen Marktwert zu steigern.
* bottom-line: Gesunde Körper (und ebenso glückliche Körper) sind produktive Körper
> ‘wellbeing provides the policy paradigm by which mind and body can be assessed as economic resources’. (Will Davies, ‘The political economy of unhappiness’, New Left Review , 71, 2011, p. 65.)
* Alenka Zupancic nennt das ganze *""Biomorality*
> Negativity, lack, dissatisfaction, unhappiness, are perceived more and more as moral faults – worse, as a corruption at the level of our very being or bare life. There is a spectacular rise of what we might call a bio-morality (as well as morality of feelings and emotions), which promotes the following fundamental axiom: a person who feels good (and is happy) is a good person; a person who feels bad is a bad person. (Alenka Zupančič, The Odd One In (Cambridge MA: MIT Press, 2008), p. 5.)'
        ]);

        DB::table('notes')->insert([
            'title' => 'Nietzsche - Genealogie der Moral, III, §15',
            'content' => '### Original


> Hat man in aller Tiefe begriffen — und ich verlange, dass man hier gerade tief greift, tief begreift — inwiefern es schlechterdings nicht die Aufgabe der Gesunden sein kann, Kranke zu warten, Kranke gesund zu machen, so ist damit auch eine Nothwendigkeit mehr begriffen, — die Nothwendigkeit von Ärzten und Krankenwärtern, die selber krank sind: und nunmehr haben und halten wir den Sinn des asketischen Priesters mit beiden Händen. Der asketische Priester muss uns als der vorherbestimmte Heiland, Hirt und Anwalt der kranken Heerde gelten: damit erst verstehen wir seine ungeheure historische Mission. Die Herrschaft über Leidende ist sein Reich, auf sie weist ihn sein Instinkt an, in ihr hat er seine eigenste Kunst, seine Meisterschaft, seine Art von Glück. Er muss selber krank sein, er muss den Kranken und Schlechtweggekommenen von Grund aus verwandt sein, um sie zu verstehen, — um sich mit ihnen zu verstehen; aber er muss auch stark sein, mehr Herr noch über sich als über Andere, unversehrt namentlich in seinem Willen zur Macht, damit er das Vertrauen und die Furcht der Kranken hat, damit er ihnen Halt, Widerstand, Stütze, Zwang, Zuchtmeister, Tyrann, Gott sein kann. Er hat sie zu vertheidigen, seine Heerde — gegen wen? Gegen die Gesunden, es ist kein Zweifel, auch gegen den Neid auf die Gesunden; er muss der natürliche Widersacher und Verächter aller rohen, stürmischen, zügellosen, harten, gewaltthätig-raubthierhaften Gesundheit und Mächtigkeit sein. Der Priester ist die erste Form des delikateren Thiers, das leichter noch verachtet als hasst. Es wird ihm nicht erspart bleiben, Krieg zu führen mit den Raubthieren, einen Krieg der List (des „Geistes“) mehr als der Gewalt, wie sich von selbst versteht, — er wird es dazu unter Umständen nöthig haben, beinahe einen neuen Raubthier-Typus an sich herauszubilden, mindestens zu bedeuten, — eine neue Thier-Furchtbarkeit, in welcher der Eisbär, die geschmeidige kalte abwartende Tigerkatze und nicht am wenigsten der Fuchs zu einer ebenso anziehenden als furchteinflössenden Einheit gebunden scheinen. Gesetzt, dass die Noth ihn zwingt, so tritt er dann wohl bärenhafternst, ehrwürdig, klug, kalt, trügerisch-überlegen, als Herold und Mundstück geheimnissvollerer Gewalten, mitten unter die andere Art Raubthiere selbst, entschlossen, auf diesem Boden Leid, Zwiespalt, Selbstwiderspruch, wo er kann, auszusäen und, seiner Kunst nur zu gewiss, über Leidende jederzeit Herr zu werden. Er bringt Salben und Balsam mit, es ist kein Zweifel; aber erst hat er nöthig, zu verwunden, um Arzt zu sein; indem er dann den Schmerz stillt, den die Wunde macht, vergiftet er zugleich die Wunde — darauf vor Allem nämlich versteht er sich, dieser Zauberer und Raubthier-Bändiger, in dessen Umkreis alles Gesunde nothwendig krank und alles Kranke nothwendig zahm wird. Er vertheidigt in der That gut genug seine kranke Heerde, dieser seltsame Hirt, — er vertheidigt sie auch gegen sich, gegen die in der Heerde selbst glimmende Schlechtigkeit, Tücke, Böswilligkeit und was sonst allen Süchtigen und Kranken unter einander zu eigen ist, er kämpft klug, hart und heimlich mit der Anarchie und der jederzeit beginnenden Selbstauflösung innerhalb der Heerde, in welcher jener gefährlichste Spreng- und Explosivstoff, das Ressentiment, sich beständig häuft und häuft. Diesen Sprengstoff so zu entladen, dass er nicht die Heerde und nicht den Hirten zersprengt, das ist sein eigentliches Kunststück, auch seine oberste Nützlichkeit; wollte man den Werth der priesterlichen Existenz in die kürzeste Formel fassen, so wäre geradewegs zu sagen: der Priester ist der Richtungs-Veränderer des Ressentiment. Jeder Leidende nämlich sucht instinktiv zu seinem Leid eine Ursache; genauer noch, einen Thäter, noch bestimmter, einen für Leid empfänglichen schuldigen Thäter, — kurz, irgend etwas Lebendiges, an dem er seine Affekte thätlich oder in effigie auf irgend einen Vorwand hin entladen kann: denn die Affekt-Entladung ist der grösste Erleichterungs- nämlich Betäubungs-Versuch des Leidenden, sein unwillkürlich begehrtes Narcoticum gegen Qual irgend welcher Art. Hierin allein ist, meiner Vermuthung nach, die wirkliche physiologische Ursächlichkeit des Ressentiment, der Rache und ihrer Verwandten, zu finden, in einem Verlangen also nach Betäubung von Schmerz durch Affekt: — man sucht dieselbe gemeinhin, sehr irrthümlich, wie mich dünkt, in dem Defensiv-Gegenschlag, einer blossen Schutzmaassregel der Reaktion, einer „Reflexbewegung“ im Falle irgend einer plötzlichen Schädigung und Gefährdung, von der Art, wie sie ein Frosch ohne Kopf noch vollzieht, um eine ätzende Säure loszuwerden. Aber die Verschiedenheit ist fundamental: im Einen Falle will man weiteres Beschädigtwerden hindern, im anderen Falle will man einen quälenden, heimlichen, unerträglich-werdenden Schmerz durch eine heftigere Emotion irgend welcher Art betäuben und für den Augenblick wenigstens aus dem Bewusstsein schaffen, — dazu braucht man einen Affekt, einen möglichst wilden Affekt und, zu dessen Erregung, den ersten besten Vorwand. „Irgend Jemand muss schuld daran sein, dass ich mich schlecht befinde“ — diese Art zu schliessen ist allen Krankhaften eigen, und zwar je mehr ihnen die wahre Ursache ihres Sich-Schlecht-Befindens, die physiologische, verborgen bleibt (— sie kann etwa in einer Erkrankung des nervus sympathicus liegen oder in einer übermässigen Gallen-Absonderung, oder an einer Armuth des Blutes an schwefel- und phosphorsaurem Kali oder in Druckzuständen des Unterleibes, welche den Blutumlauf stauen, oder in Entartung der Eierstöcke und dergleichen). Die Leidenden sind allesammt von einer entsetzlichen Bereitwilligkeit und Erfindsamkeit in Vorwänden zu schmerzhaften Affekten; sie geniessen ihren Argwohn schon, das Grübeln über Schlechtigkeiten und scheinbare Beeinträchtigungen, sie durchwühlen die Eingeweide ihrer Vergangenheit und Gegenwart nach dunklen fragwürdigen Geschichten, wo es ihnen freisteht, in einem quälerischen Verdachte zu schwelgen und am eignen Gifte der Bosheit sich zu berauschen — sie reissen die ältesten Wunden auf, sie verbluten sich an längst ausgeheilten Narben, sie machen Übelthäter aus Freund, Weib, Kind und was sonst ihnen am nächsten steht. „Ich leide: daran muss irgend Jemand schuld sein“ — also denkt jedes krankhafte Schaf. Aber sein Hirt, der asketische Priester, sagt zu ihm: „Recht so, mein Schaf! irgend wer muss daran schuld sein: aber du selbst bist dieser Irgend-Wer, du selbst bist daran allein schuld, — du selbst bist an dir allein schuld!“… Das ist kühn genug, falsch genug: aber Eins ist damit wenigstens erreicht, damit ist, wie gesagt, die Richtung des Ressentiment — verändert.'
        ]);
        
        DB::table('tags')->insert([['name' => "Arbeit"],
        						  ['name' => "Arbeitsteilung"],
        						  ['name' => "Asketismus"],
        						  ['name' => "Autonomismus"],
        						  ['name' => "Begierde / Verlangen / Wunsch"],
        						  ['name' => "Familie"],
        						  ['name' => "Feminismus"],
        						  ['name' => "Forderung"],
        						  ['name' => "Frauen"],
        						  ['name' => "Fredric Jameson"],
        						  ['name' => "Gender"],
        						  ['name' => "Gesellschaft"],
        						  ['name' => "Kathi Weeks"],
        						  ['name' => "Klassenkampf"],
        						  ['name' => "Kritik"],
        						  ['name' => "Macht"],
        						  ['name' => "Produktion"],
        						  ['name' => "Nihilismus"],
        						  ['name' => "Hegel is my waifu"],
        						  ['name' => "ToDo"],
        						  ['name' => "ToGulag"],
        						  ['name' => "Base > Superstructure"],
        						  ['name' => "ToGulag"],
        						  ['name' => "Lorem Ipsum Dolor Sit Amet, consectetur adipisici elit, sed eiusmod tempor"]]);
        						  
		// We have 14 notes and 24 tags - let's assign them a little bit randomly
		DB::table('note_tag')->insert([['note_id' => 1, 'tag_id' =>2],
									  ['note_id' => 1, 'tag_id' =>3],
									  ['note_id' => 1, 'tag_id' =>5],
									  ['note_id' => 1, 'tag_id' =>6],
									  ['note_id' => 1, 'tag_id' =>12],
									  ['note_id' => 2, 'tag_id' =>3],
									  ['note_id' => 2, 'tag_id' =>8],
									  ['note_id' => 2, 'tag_id' =>9],
									  ['note_id' => 2, 'tag_id' =>16],
									  ['note_id' => 3, 'tag_id' =>3],
									  ['note_id' => 3, 'tag_id' =>16],
									  ['note_id' => 4, 'tag_id' =>16],
									  ['note_id' => 4, 'tag_id' =>17],
									  ['note_id' => 4, 'tag_id' =>20],
									  ['note_id' => 4, 'tag_id' =>22],
									  ['note_id' => 4, 'tag_id' =>23],
									  ['note_id' => 5, 'tag_id' =>1],
									  ['note_id' => 5, 'tag_id' =>2],
									  ['note_id' => 5, 'tag_id' =>14],
									  ['note_id' => 6, 'tag_id' =>1],
									  ['note_id' => 6, 'tag_id' =>5],
									  ['note_id' => 6, 'tag_id' =>9],
									  ['note_id' => 6, 'tag_id' =>24],
									  ['note_id' => 7, 'tag_id' =>22],
									  ['note_id' => 7, 'tag_id' =>23],
									  ['note_id' => 8, 'tag_id' =>10],
									  ['note_id' => 9, 'tag_id' =>3],
									  ['note_id' => 9, 'tag_id' =>7],
									  ['note_id' => 9, 'tag_id' =>8],
									  ['note_id' => 9, 'tag_id' =>14],
									  ['note_id' => 9, 'tag_id' =>20],
									  ['note_id' => 10, 'tag_id' =>3],
									  ['note_id' => 10, 'tag_id' =>7],
									  ['note_id' => 10, 'tag_id' =>9],
									  ['note_id' => 10, 'tag_id' =>10],
									  ['note_id' => 11, 'tag_id' =>5],
									  ['note_id' => 11, 'tag_id' =>6],
									  ['note_id' => 11, 'tag_id' =>7],
									  ['note_id' => 12, 'tag_id' =>1],
									  ['note_id' => 12, 'tag_id' =>2],
									  ['note_id' => 12, 'tag_id' =>3],
									  ['note_id' => 13, 'tag_id' =>10],
									  ['note_id' => 13, 'tag_id' =>11],
									  ['note_id' => 13, 'tag_id' =>12],
									  ['note_id' => 13, 'tag_id' =>13],
									  ['note_id' => 13, 'tag_id' =>14],
									  ['note_id' => 14, 'tag_id' =>15],
									  ['note_id' => 14, 'tag_id' =>16]]);
        
    }
}
