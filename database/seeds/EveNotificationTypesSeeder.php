<?php namespace SeIT\Database\Seeds;

use Illuminate\Database\Seeder;

class EveNotificationTypesSeeder extends Seeder
{
    public function run()
    {
        \DB::table('eve_notification_types')->truncate();

        \DB::table('eve_notification_types')->insert(
            array(
                array(
                    "typeID" => "1",
                    "description" => "Legacy",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "2",
                    "description" => "Character deleted",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "3",
                    "description" => "Give medal to character",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "4",
                    "description" => "Alliance maintenance bill",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "5",
                    "description" => "Alliance war declared",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "6",
                    "description" => "Alliance war surrender",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "7",
                    "description" => "Alliance war retracted",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "8",
                    "description" => "Alliance war invalidated by Concord",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "9",
                    "description" => "Bill issued to a character",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "10",
                    "description" => "Bill issued to corporation or alliance",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "11",
                    "description" => "Bill not paid because there's not enough ISK available",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "12",
                    "description" => "Bill",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "13",
                    "description" => "Bill",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "14",
                    "description" => "Bounty claimed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "15",
                    "description" => "Clone activated",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "16",
                    "description" => "New corp member application",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "17",
                    "description" => "Corp application rejected",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "18",
                    "description" => "Corp application accepted",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "19",
                    "description" => "Corp tax rate changed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "20",
                    "description" => "Corp news report",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "21",
                    "description" => "Player leaves corp",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "22",
                    "description" => "Corp news",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "23",
                    "description" => "Corp dividend/liquidation",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "24",
                    "description" => "Corp dividend payout",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "25",
                    "description" => "Corp vote created",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "26",
                    "description" => "Corp CEO votes revoked during voting",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "27",
                    "description" => "Corp declares war",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "28",
                    "description" => "Corp war has started",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "29",
                    "description" => "Corp surrenders war",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "30",
                    "description" => "Corp retracts war",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "31",
                    "description" => "Corp war invalidated by Concord",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "32",
                    "description" => "Container password retrieval",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "33",
                    "description" => "Contraband or low standings cause an attack or items being confiscated",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "34",
                    "description" => "First ship insurance",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "35",
                    "description" => "Ship destroyed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "36",
                    "description" => "Insurance contract invalidated/runs out",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "37",
                    "description" => "Sovereignty claim fails (alliance)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "38",
                    "description" => "Sovereignty claim fails (corporation)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "39",
                    "description" => "Sovereignty bill late (alliance)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "40",
                    "description" => "Sovereignty bill late (corporation)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "41",
                    "description" => "Sovereignty claim lost (alliance)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "42",
                    "description" => "Sovereignty claim lost (corporation)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "43",
                    "description" => "Sovereignty claim acquired (alliance)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "44",
                    "description" => "Sovereignty claim acquired (corporation)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "45",
                    "description" => "Alliance anchoring alert",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "46",
                    "description" => "Alliance structure turns vulnerable",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "47",
                    "description" => "Alliance structure turns invulnerable",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "48",
                    "description" => "Sovereignty disruptor anchored",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "49",
                    "description" => "Structure won/lost",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "50",
                    "description" => "Corp office lease expiration notice",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "51",
                    "description" => "Clone contract revoked by station manager",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "52",
                    "description" => "Corp member clones moved between stations",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "53",
                    "description" => "Clone contract revoked by station manager",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "54",
                    "description" => "Insurance contract expired",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "55",
                    "description" => "Insurance contract issued",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "56",
                    "description" => "Jump clone destroyed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "57",
                    "description" => "Jump clone destroyed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "58",
                    "description" => "Corporation joining factional warfare",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "59",
                    "description" => "Corporation leaving factional warfare",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "60",
                    "description" => "Corporation kicked from factional warfare on startup because of too low standing to the faction",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "61",
                    "description" => "Character kicked from factional warfare on startup because of too low standing to the faction",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "62",
                    "description" => "Corporation in factional warfare warned on startup because of too low standing to the faction",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "63",
                    "description" => "Character in factional warfare warned on startup because of too low standing to the faction",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "64",
                    "description" => "Character loses factional warfare rank",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "65",
                    "description" => "Character gains factional warfare rank",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "66",
                    "description" => "Agent has moved",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "67",
                    "description" => "Mass transaction reversal message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "68",
                    "description" => "Reimbursement message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "69",
                    "description" => "Agent locates a character",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "70",
                    "description" => "Research mission becomes available from an agent",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "71",
                    "description" => "Agent mission offer expires",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "72",
                    "description" => "Agent mission times out",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "73",
                    "description" => "Agent offers a storyline mission",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "74",
                    "description" => "Tutorial message sent on character creation",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "75",
                    "description" => "Tower alert",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "76",
                    "description" => "Tower resource alert",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "77",
                    "description" => "Station service aggression message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "78",
                    "description" => "Station state change message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "79",
                    "description" => "Station conquered message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "80",
                    "description" => "Station aggression message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "81",
                    "description" => "Corporation requests joining factional warfare",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "82",
                    "description" => "Corporation requests leaving factional warfare",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "83",
                    "description" => "Corporation withdrawing a request to join factional warfare",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "84",
                    "description" => "Corporation withdrawing a request to leave factional warfare",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "85",
                    "description" => "Corporation liquidation",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "86",
                    "description" => "Territorial Claim Unit under attack",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "87",
                    "description" => "Sovereignty Blockade Unit under attack",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "88",
                    "description" => "Infrastructure Hub under attack",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "89",
                    "description" => "Contact add notification",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "90",
                    "description" => "Contact edit notification",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "91",
                    "description" => "Incursion Completed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "92",
                    "description" => "Corp Kicked",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "93",
                    "description" => "Customs office has been attacked",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "94",
                    "description" => "Customs office has entered reinforced",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "95",
                    "description" => "Customs office has been transferred",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "96",
                    "description" => "FW Alliance Warning",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "97",
                    "description" => "FW Alliance Kick",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "98",
                    "description" => "AllWarCorpJoined Msg",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "99",
                    "description" => "Ally Joined Defender",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "100",
                    "description" => "Ally Has Joined a War Aggressor",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "101",
                    "description" => "Ally Joined War Ally",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "102",
                    "description" => "New war system: entity is offering assistance in a war.",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "103",
                    "description" => "War Surrender Offer",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "104",
                    "description" => "War Surrender Declined",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "105",
                    "description" => "FacWar LP Payout Kill",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "106",
                    "description" => "FacWar LP Payout Event",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "107",
                    "description" => "FacWar LP Disqualified Eventd",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "108",
                    "description" => "FacWar LP Disqualified Kill",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "109",
                    "description" => "Alliance Contract Cancelled",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "110",
                    "description" => "War Ally Declined Offer",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "111",
                    "description" => "Your Bounty Claimed",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "112",
                    "description" => "Bounty Placed (Char)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "113",
                    "description" => "Bounty Placed (Corp)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "114",
                    "description" => "Bounty Placed (Alliance)",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "115",
                    "description" => "Kill Right Available",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "116",
                    "description" => "Kill Right Available Open",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "117",
                    "description" => "Kill Right Earned",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "118",
                    "description" => "Kill Right Used",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "119",
                    "description" => "Kill Right Unavailable",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "120",
                    "description" => "Kill Right Unavailable Open",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "121",
                    "description" => "Declare War",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "122",
                    "description" => "Offered Surrender",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "123",
                    "description" => "Accepted Surrender",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "124",
                    "description" => "Made War Mutual",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "125",
                    "description" => "Retracts War",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "126",
                    "description" => "Offered To Ally",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "127",
                    "description" => "Accepted Ally",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "128",
                    "description" => "Character Application Accept Message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "129",
                    "description" => "Character Application Reject Message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),
                array(
                    "typeID" => "130",
                    "description" => "Character Application Withdraw Message",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
                ),

            )
        );
    }
}
