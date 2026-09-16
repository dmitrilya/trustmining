<?php

return [
    'mining' => [
        'title' => 'Cryptocurrency Mining Terms',
        'description' => 'Mining glossary covering hashrate, difficulty, blocks, rewards, pools, Proof-of-Work and other cryptocurrency mining terms.',
        'name' => 'Mining',
        'caption' => 'Terms related to cryptocurrency mining, including hashrate, network difficulty, blocks, rewards, Proof-of-Work, shares and other mining concepts.',
        'terms' => [
            'mining' => [
                'title' => 'What Is Mining and How Does It Work | TM Wiki',
                'description' => 'Mining is the process of using computational resources to create blocks, secure a blockchain, and earn cryptocurrency rewards.',
                'name' => 'Mining',
                'caption' => 'The process of using computational resources to participate in blockchain operations and earn rewards.',
                'definition' => '<p><strong>Mining</strong> is the process of using computational resources to participate in the operation of a blockchain network, validate transactions, and create new blocks. In networks that use <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, miners perform computations to find a solution to a cryptographic problem. A participant who successfully creates a valid block and gets it accepted by the network receives the <span class="term" data-term="mining/block-reward">block reward</span> specified by the protocol.</p>

                <h3>How Mining Works</h3>

                <p>During mining, a computing device receives a set of data associated with the block being created and repeatedly performs computations, changing a specific value until the result meets the protocol requirements. In Proof-of-Work, this process must have a verifiable computational cost, while verifying a discovered solution is significantly easier.</p>

                <p>After a suitable solution is found, the new block is transmitted to other network participants. If the block complies with the protocol rules and does not conflict with the accepted blockchain history, it becomes part of the chain. Thus, mining provides both a mechanism for creating new blocks and an economic mechanism for securing the network.</p>

                <h3>Mining Hardware</h3>

                <p>Mining uses computing devices capable of efficiently executing a specific network algorithm. Depending on the blockchain, these may include specialized ASIC miners, graphics processing units, or central processing units. A device that directly performs the computational work is usually called a <span class="term" data-term="mining/miner">miner</span>.</p>

                <p>Hardware efficiency is determined not only by its computational power. Practical evaluation also requires considering power consumption, electricity cost, operating stability, cooling efficiency, hardware cost, and current network parameters.</p>

                <h3>Mining Methods</h3>

                <p>Mining can be performed independently or jointly with other participants. In <span class="term" data-term="mining/solo-mining">solo mining</span>, a participant independently searches for a block and, if successful, receives the reward specified by the protocol. In <span class="term" data-term="mining/pooled-mining">Pooled Mining</span>, the computational resources of multiple participants are combined through a mining pool, and payments are distributed among them according to the pool\'s rules.</p>

                <p>There are also other ways to organize computational work. For example, <span class="term" data-term="mining/merge-mining">Merge Mining</span> allows the same computational work to be used to participate in multiple compatible blockchains, while <span class="term" data-term="mining/dual-mining">Dual Mining</span> can use a single device to mine two cryptocurrencies simultaneously.</p>

                <h3>What Affects Mining Profitability</h3>

                <p>Mining economics are determined by the relationship between the rewards received and the costs of operating the equipment. The main factors include:</p>

                <ul>
                    <li>computational power of the equipment;</li>
                    <li>power consumption;</li>
                    <li>electricity cost;</li>
                    <li>network difficulty;</li>
                    <li>price of the mined cryptocurrency;</li>
                    <li>block reward;</li>
                    <li>mining pool fee;</li>
                    <li>cooling, maintenance, and infrastructure costs.</li>
                </ul>

                <p>A change in any of these parameters can significantly affect profitability. For example, an increase in network difficulty, with all other conditions unchanged, reduces the expected share of the reward attributable to each unit of computational power.</p>

                <h3>Miner Reward</h3>

                <p>Depending on the rules of a particular network, the <span class="term" data-term="mining/block-reward">block reward</span> may consist of several components. One is the <span class="term" data-term="mining/block-subsidy">block subsidy</span>, which is associated with the issuance of new coins. Another component is transaction fees included in the created block.</p>

                <p>Information about the reward payment is recorded through a special <span class="term" data-term="mining/coinbase-transaction">Coinbase Transaction</span>. The rules for forming this transaction and the permitted payment amount are determined by the protocol of the specific blockchain.</p>

                <h3>Mining as an Activity</h3>

                <p>On a small scale, mining may involve operating one or several devices. At an industrial scale, it becomes a full-scale mining operation that includes managing large amounts of equipment, power supply, cooling, monitoring, and technical maintenance.</p>

                <p>The process is managed using <span class="term" data-term="mining/mining-software">mining software</span>, <span class="term" data-term="mining/mining-client">mining clients</span>, and corresponding <span class="term" data-term="mining/mining-protocol">mining protocols</span>.</p>',
            ],

            'miner' => [
                'title' => 'What Is a Miner and How Does It Work | TM Wiki',
                'description' => 'A miner is a device or software participant that performs computations to mine cryptocurrency and create new blocks.',
                'name' => 'Miner',
                'caption' => 'A device or software participant that uses computational resources to mine cryptocurrency.',
                'definition' => '<p><strong>Miner</strong> is a device or software participant that performs the computational work required to mine cryptocurrency in blockchain networks that support mining. In the context of Proof-of-Work, a miner participates in finding a solution that allows a new block to be added to the chain.</p>

                <p>The term is used in two related senses. It can refer directly to a physical device, such as an ASIC miner, GPU farm, or computer. A miner can also refer to a network participant or software component that performs computations and interacts with the network or a pool.</p>

                <h3>Main Types of Miners</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Features</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ASIC</td>
                            <td>A specialized device for a specific algorithm. It is typically characterized by high efficiency.</td>
                        </tr>
                        <tr>
                            <td>GPU</td>
                            <td>Uses graphics processors and can be used for different algorithms and coins.</td>
                        </tr>
                        <tr>
                            <td>CPU</td>
                            <td>Uses a computer\'s central processing unit. Suitable for networks whose algorithms are designed for CPU mining.</td>
                        </tr>
                    </tbody>
                </table>

                <h3>How a Miner Works</h3>

                <p>A miner receives a task through <span class="term" data-term="mining/mining-software">mining software</span> or directly through a <span class="term" data-term="mining/mining-client">mining client</span>. The device performs a large number of computations according to the network algorithm and sends the resulting work back.</p>

                <p>When operating through a pool, a miner typically does not attempt to independently find a complete block during every computational cycle. It performs tasks assigned by the pool, and the results are used to measure the actual computational contribution. When mining independently, the participant operates without a pool intermediary.</p>

                <h3>Main Miner Characteristics</h3>

                <p>Several parameters are typically considered when evaluating a miner:</p>

                <ul>
                    <li><strong>hashrate</strong> — performance when performing computations;</li>
                    <li><strong>power consumption</strong> — the amount of electricity required for operation;</li>
                    <li><strong>power efficiency</strong> — the ratio of performance to power consumption;</li>
                    <li><strong>supported algorithm</strong> — determines which networks and coins the device can mine;</li>
                    <li><strong>hardware cost</strong> — affects the payback period;</li>
                    <li><strong>reliability and operating conditions</strong> — affect actual equipment availability and costs.</li>
                </ul>

                <p>Therefore, a more powerful miner is not necessarily more profitable. When comparing equipment, income, energy costs, device price, and current network parameters must all be considered together.</p>',
            ],

            'proof-of-work' => [
                'title' => 'What Is Proof-of-Work in Mining | TM Wiki',
                'description' => 'Proof-of-Work is a consensus mechanism that uses computational work to create blocks and secure a blockchain network.',
                'name' => 'Proof-of-Work',
                'caption' => 'A consensus mechanism based on performing computational work to create new blocks.',
                'definition' => '<p><strong>Proof-of-Work (PoW)</strong> is a consensus mechanism in which participants in a blockchain network perform computational work to obtain the right to propose a new block. Unlike mechanisms based on asset ownership or voting, PoW uses measurable computational cost as one of the main elements of network security.</p>

                <h3>How Proof-of-Work Works</h3>

                <p>When creating a block, a value must be found such that the result of cryptographic hashing meets a condition established by the protocol. Since it is practically impossible to predict a suitable value in advance, a participant must perform a large number of attempts.</p>

                <p>Each individual attempt is relatively simple, but finding a suitable result requires a significant amount of computation. Once a solution is found, other participants can quickly verify its correctness.</p>

                <h3>The Role of Network Difficulty</h3>

                <p>The network adjusts the required difficulty of the computational task so that new blocks are produced at the frequency specified by the protocol. If the total computational power of the network increases, difficulty may also increase in networks with an automatic difficulty adjustment mechanism.</p>

                <p>Therefore, changes in the computational power of individual miners and the network as a whole affect the probability of a particular participant finding a block.</p>

                <h3>Network Security</h3>

                <p>One of the key properties of Proof-of-Work is that creating an alternative blockchain history requires significant computational resources. The more computational work accumulated in the chain, the more expensive an attempt to rewrite its history becomes.</p>

                <p>The economic model additionally incentivizes honest participation: a miner consumes electricity and uses hardware with the expectation of receiving a <span class="term" data-term="mining/block-reward">block reward</span>. An attack on the network requires not only computational resources but also the corresponding costs of operating them.</p>

                <h3>Proof-of-Work and Mining</h3>

                <p><span class="term" data-term="mining/mining">Mining</span> in PoW networks represents the practical implementation of the computational work required by this consensus mechanism. Miners compete for the opportunity to add the next block by performing computations using specialized or general-purpose hardware.</p>',
            ],

            'solo-mining' => [
                'title' => 'What Is Solo Mining and How Does It Work | TM Wiki',
                'description' => 'Solo mining is the independent mining of blocks without participating in a pool, with the miner receiving the full block reward when a block is found.',
                'name' => 'Solo Mining',
                'caption' => 'Independent mining without combining computational resources with other participants.',
                'definition' => '<p><strong>Solo mining</strong> is a method of mining cryptocurrency in which a miner independently participates in finding new blocks without combining computational resources with other participants through a pool.</p>

                <p>When a block is successfully found, the participant receives the <span class="term" data-term="mining/block-reward">block reward</span> specified by the protocol. It is not distributed among other miners because the computational work was not combined within a shared pool.</p>

                <h3>How Solo Mining Works</h3>

                <p>The miner independently connects to the blockchain network or uses appropriate software, receives the data required to construct a block, and performs the necessary computations. If the discovered solution satisfies the network rules and the block is accepted by other participants, the miner receives the specified reward.</p>

                <p>The key feature of solo mining is the probabilistic nature of its income. Having greater computational power increases the probability of finding a block but does not guarantee regular payouts.</p>

                <h3>Solo Mining vs. Pool Mining</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Characteristic</th>
                            <th>Solo Mining</th>
                            <th>Pool Mining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Computational power</td>
                            <td>Used independently</td>
                            <td>Combined with other participants</td>
                        </tr>
                        <tr>
                            <td>Payouts</td>
                            <td>Irregular, when a block is found</td>
                            <td>Typically more frequent and smaller</td>
                        </tr>
                        <tr>
                            <td>Reward distribution</td>
                            <td>The participant receives the reward independently</td>
                            <td>The reward is distributed among participants</td>
                        </tr>
                        <tr>
                            <td>Dependence on a pool</td>
                            <td>None</td>
                            <td>Yes</td>
                        </tr>
                    </tbody>
                </table>

                <h3>When Solo Mining Makes Sense</h3>

                <p>Solo mining becomes more predictable when a participant has a large share of the network\'s total computational power. With a small amount of computational power, the probability of finding a block may be so low that periods without income become very long.</p>

                <p>Therefore, when evaluating solo mining, it is important to consider not only the expected average profitability but also the probability of experiencing a prolonged period without finding a block.</p>',
            ],

            'pooled-mining' => [
                'title' => 'What Is Pooled Mining and How Does It Work | TM Wiki',
                'description' => 'Pooled Mining is collaborative mining in which participants combine computational power and distribute the resulting payouts.',
                'name' => 'Pooled Mining',
                'caption' => 'Collaborative mining in which multiple participants combine computational power for more regular payouts.',
                'definition' => '<p><strong>Pooled Mining</strong> is a collaborative method of mining cryptocurrency in which multiple participants combine computational power through a mining pool. The main purpose of this approach is to increase the frequency of blocks found by the group and make payouts to individual participants more regular.</p>

                <h3>How Pool Mining Works</h3>

                <p>The pool coordinates the work of connected miners. It distributes computational tasks among them, receives their results, and tracks each participant\'s contribution.</p>

                <p>When one of the pool participants finds a block, the resulting <span class="term" data-term="mining/block-reward">block reward</span> is recorded by the pool and then distributed among participants according to the selected payout system.</p>

                <h3>Why Combine Computational Power</h3>

                <p>The probability that a small individual miner will independently find a block can be very low. Combining a large number of devices increases the total computational power and therefore the frequency of blocks found by the group.</p>

                <p>For an individual participant, this changes the income structure: instead of a rare large event, the participant receives smaller payouts corresponding to their contribution to the pool\'s overall work.</p>

                <h3>Payout Systems</h3>

                <p>The specific calculation method depends on the payout system used by the pool. Different schemes may take into account the number of submitted solutions, their difficulty, operating time, successful block discoveries, and other parameters.</p>

                <p>When choosing a pool, it is important to consider not only the stated fee but also the minimum payout amount, payout rules, operating stability, payout delays, and the <span class="term" data-term="mining/mining-protocol">mining protocol</span> being used.</p>

                <h3>Advantages and Disadvantages</h3>

                <ul>
                    <li><strong>Advantage:</strong> a more stable cash flow compared with a small-scale solo mining operation.</li>
                    <li><strong>Advantage:</strong> there is no need to independently maintain enough computational power to find blocks regularly.</li>
                    <li><strong>Disadvantage:</strong> the pool charges a fee or applies other service conditions.</li>
                    <li><strong>Disadvantage:</strong> the participant depends on the pool\'s infrastructure and rules.</li>
                    <li><strong>Disadvantage:</strong> the received reward is distributed among all participants.</li>
                </ul>',
            ],

            'merge-mining' => [
                'title' => 'What Is Merge Mining and How Does It Work | TM Wiki',
                'description' => 'Merge Mining is a technology for simultaneously mining multiple compatible blockchains using the same computational work.',
                'name' => 'Merge Mining',
                'caption' => 'A technology that uses the same computational work to mine multiple compatible blockchains.',
                'definition' => '<p><strong>Merge Mining</strong> is a technology that allows the same computational work to be used simultaneously for mining multiple compatible blockchains. As a result, a miner can receive rewards from multiple networks without performing a completely separate amount of computation for each one.</p>

                <h3>How Merge Mining Works</h3>

                <p>One network typically acts as the primary chain, while an auxiliary network uses proof of completed work to verify that a computational task has already been solved. If the solution meets the requirements of the auxiliary blockchain, it may also be accepted by that network.</p>

                <p>Thus, the auxiliary blockchain can use computational work that has already been performed as part of the primary network. This allows a smaller network to increase its security without having to independently attract a comparable amount of computational resources.</p>

                <h3>Economic Meaning</h3>

                <p>For miners, the main advantage of Merge Mining is the ability to receive additional rewards without a proportional increase in computational workload. Additional profitability depends on the specific rules of the networks and the value of the assets received.</p>

                <p>However, Merge Mining requires technical compatibility between the blockchains. Not every PoW network can use this technology, and the mechanism for verifying the proof of work must be provided for by the protocol.</p>

                <h3>Relationship with Proof-of-Work</h3>

                <p>Merge Mining is particularly associated with blockchains that use a compatible <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span> mechanism. Its purpose is not to change the mining principle itself, but to reuse computational work that has already been performed in another compatible network.</p>',
            ],

            'dual-mining' => [
                'title' => 'What Is Dual Mining and How Does It Work | TM Wiki',
                'description' => 'Dual Mining is a mode of simultaneously mining two cryptocurrencies with a single device using compatible computational resources.',
                'name' => 'Dual Mining',
                'caption' => 'A mode of simultaneously mining two cryptocurrencies with a single computing device.',
                'definition' => '<p><strong>Dual Mining</strong> is a mode in which a single computing device simultaneously participates in mining two cryptocurrencies or performing two mining tasks. This capability depends on the hardware architecture, software being used, and algorithm compatibility.</p>

                <h3>How Dual Mining Works</h3>

                <p>In conventional mining, a device directs its available computational resources toward a single task. In Dual Mining, resources are divided between two tasks. The specific mechanism depends on the hardware and <span class="term" data-term="mining/mining-software">mining software</span> being used.</p>

                <p>In some implementations, the primary task uses most of the available resources while the second task uses the remaining capacity. In other configurations, the device architecture allows two types of computations to be performed more concurrently.</p>

                <h3>Advantages</h3>

                <ul>
                    <li>the ability to earn income from two assets simultaneously;</li>
                    <li>more complete utilization of the hardware\'s computational resources;</li>
                    <li>the ability to diversify the assets being mined;</li>
                    <li>potentially higher overall device profitability.</li>
                </ul>

                <h3>Limitations</h3>

                <p>Dual Mining does not automatically mean higher net profit. The additional task may increase power consumption, temperature, and hardware load. In some configurations, the performance of the primary task may also decrease.</p>

                <p>Therefore, this mode should be evaluated based on total net profit after accounting for electricity costs, reduced performance, fees, and other operating expenses.</p>

                <h3>Dual Mining vs. Merge Mining</h3>

                <p>Dual Mining should not be confused with <span class="term" data-term="mining/merge-mining">Merge Mining</span>. In Merge Mining, the same computational work can be used for multiple compatible blockchains, whereas Dual Mining generally involves simultaneously performing two separate mining tasks.</p>',
            ],

            'mining-software' => [
                'title' => 'What Is Mining Software and What Is It Used For | TM Wiki',
                'description' => 'Mining software is software used to launch, configure, and manage the cryptocurrency mining process.',
                'name' => 'Mining Software',
                'caption' => 'Software that configures and performs mining on computing hardware.',
                'definition' => '<p><strong>Mining software</strong> is software that launches and manages the cryptocurrency mining process on computing hardware. It connects the hardware to a network or pool and organizes the execution of computational tasks.</p>

                <h3>Main Functions</h3>

                <p>Depending on the specific solution, mining software may perform the following tasks:</p>

                <ul>
                    <li>selecting the algorithm and mining parameters;</li>
                    <li>connecting to a mining pool or network;</li>
                    <li>receiving computational tasks;</li>
                    <li>submitting completed work;</li>
                    <li>monitoring hardware performance;</li>
                    <li>managing clock frequencies, power consumption, and other parameters;</li>
                    <li>handling errors and reconnecting;</li>
                    <li>maintaining performance statistics.</li>
                </ul>

                <h3>Mining Software and Hardware</h3>

                <p>Depending on the type of hardware, software may be installed directly on the device, on a separate computer, or on a management server. In ASIC miners, a significant portion of the software logic is typically integrated into the device firmware, while GPU mining often requires a separate software client.</p>

                <p>Software functionality can have a significant effect on the actual performance of the hardware. Configuration optimization, power management, and connection stability can affect the economic performance of the device.</p>

                <h3>Software Client and Protocol</h3>

                <p>A <span class="term" data-term="mining/mining-client">mining client</span> is part of the broader concept of mining software. The client handles direct interaction with the network or pool, while the software suite may additionally include a management interface, monitoring, configuration, and other functions.</p>

                <p>Data exchange between components takes place according to the <span class="term" data-term="mining/mining-protocol">mining protocol</span> being used.</p>',
            ],

            'mining-client' => [
                'title' => 'What Is a Mining Client | TM Wiki',
                'description' => 'A mining client is software that enables a computing device to interact with a network or mining pool.',
                'name' => 'Mining Client',
                'caption' => 'Software that enables a computing device to interact with a network or mining pool.',
                'definition' => '<p><strong>Mining client</strong> is a software component that enables a computing device to interact with a blockchain network or mining pool while mining cryptocurrency.</p>

                <p>The client receives computational tasks, sends them to the hardware, receives the results, and submits the completed work. Depending on the implementation, it may also handle server selection, authentication, error handling, and connection status monitoring.</p>

                <h3>Basic Operating Cycle</h3>

                <ol>
                    <li>The client establishes a connection to a pool or another network component.</li>
                    <li>It receives the required data and computational task.</li>
                    <li>It sends the task to the computing hardware.</li>
                    <li>It receives the computation results.</li>
                    <li>It verifies them at the level provided by the implementation.</li>
                    <li>It submits the result to the pool or network.</li>
                    <li>It receives the next task and repeats the cycle.</li>
                </ol>

                <h3>Difference from Mining Software</h3>

                <p><span class="term" data-term="mining/mining-software">Mining software</span> is a broader concept. It may include the client itself, hardware configuration tools, monitoring, management of multiple devices, and other components.</p>

                <p>The mining client is the functional core responsible directly for performing and submitting mining work.</p>

                <h3>Communication Protocol</h3>

                <p>The client uses the appropriate <span class="term" data-term="mining/mining-protocol">mining protocol</span> to exchange tasks and results. The choice of protocol depends on the specific network, pool, and software.</p>',
            ],

            'mining-protocol' => [
                'title' => 'What Is a Mining Protocol and How Does It Work | TM Wiki',
                'description' => 'A mining protocol is a set of rules for exchanging data between miners, pools, and networks while computational work is being performed.',
                'name' => 'Mining Protocol',
                'caption' => 'Rules for exchanging tasks and work results between a miner and other participants in the mining process.',
                'definition' => '<p><strong>Mining protocol</strong> is a set of rules and data formats that defines interaction between computing hardware, mining software, a pool, and, in some cases, the blockchain network itself.</p>

                <h3>What Data Is Transmitted</h3>

                <p>Depending on the implementation, the protocol defines how a miner receives tasks, which parameters are used for computations, and how completed work is submitted. It may also transmit worker identifiers, connection status information, and error messages.</p>

                <p>The protocol must allow the pool or network to unambiguously determine which participant performed the work and whether the submitted result meets the established requirements.</p>

                <h3>Why a Protocol Is Needed</h3>

                <p>Without a standardized method of data exchange, a computing device would not be able to properly receive tasks and report results. The protocol provides a common language for interaction between the <span class="term" data-term="mining/mining-client">mining client</span> and the server-side infrastructure.</p>

                <p>Different protocols may differ in architecture, authentication methods, message formats, support for additional features, and connection requirements.</p>

                <h3>Role in Mining Infrastructure</h3>

                <p>In a typical <span class="term" data-term="mining/mining">mining</span> setup, computing hardware interacts with a pool through a software client, and the client uses an appropriate protocol. The stability of this interaction affects latency, the amount of lost work, and the correct transmission of results.</p>

                <p>Therefore, when selecting software, it is important to consider compatibility between the hardware, pool, and protocol being used.</p>',
            ],

            'block-reward' => [
                'title' => 'What Is a Block Reward | TM Wiki',
                'description' => 'A block reward is the total income associated with creating a new block, including the subsidy and, depending on the network, transaction fees.',
                'name' => 'Block Reward',
                'caption' => 'The total income associated with adding a new block to the blockchain.',
                'definition' => '<p><strong>Block reward</strong> is the total income received by a network participant for creating and having a new block accepted by the blockchain. Depending on the rules of a particular network, it may consist of several components.</p>

                <h3>What the Reward Consists Of</h3>

                <p>The most common structure includes:</p>

                <ul>
                    <li><strong>block subsidy</strong> — the amount of new coins created by the protocol;</li>
                    <li><strong>transaction fees</strong> — amounts associated with transactions included in the block.</li>
                </ul>

                <p>These components may have different economic significance depending on the specific blockchain and the current activity of its users.</p>

                <h3>Subsidy and Fees</h3>

                <p>The <span class="term" data-term="mining/block-subsidy">block subsidy</span> is determined by the protocol rules. In some networks, it gradually decreases according to a predefined schedule. The fee component depends on user activity and demand for transaction inclusion.</p>

                <p>The reward is recorded through a special <span class="term" data-term="mining/coinbase-transaction">Coinbase Transaction</span>.</p>

                <h3>Impact on Mining Profitability</h3>

                <p>The size of the reward is directly related to the economics of <span class="term" data-term="mining/mining">mining</span>. With unchanged computational power, a reduction in the reward decreases expected income if all other parameters remain unchanged.</p>

                <p>However, actual profitability depends not only on the size of the reward. Network difficulty, total hashrate, electricity cost, pool fees, and the market value of the coins received must also be considered.</p>',
            ],

            'block-subsidy' => [
                'title' => 'What Is a Block Subsidy in Mining | TM Wiki',
                'description' => 'A block subsidy is the portion of the block reward determined by the protocol and associated with the issuance of new coins.',
                'name' => 'Block Subsidy',
                'caption' => 'The portion of the block reward determined by protocol rules and typically associated with the issuance of new coins.',
                'definition' => '<p><strong>Block subsidy</strong> is the portion of the <span class="term" data-term="mining/block-reward">block reward</span> whose amount is determined by the rules of a particular blockchain. In networks that issue new coins, the subsidy represents the number of new units of the asset created when a block is formed.</p>

                <h3>How the Subsidy Is Determined</h3>

                <p>The subsidy amount is specified by the protocol. It is not determined directly by the miner and does not depend on the miner\'s computational power. If a miner successfully creates a block, it can receive only the subsidy specified by the network rules at that time.</p>

                <p>In some blockchains, the subsidy remains constant; in others, it gradually decreases. Changes may occur through predefined events or protocol conditions.</p>

                <h3>Subsidy and Fees</h3>

                <p>The subsidy should not be confused with transaction fees. The subsidy is related to issuance rules and is provided by the protocol for creating a block, while fees are generated by users when they submit transactions.</p>

                <p>Both components may form part of the miner\'s total reward and be recorded in the <span class="term" data-term="mining/coinbase-transaction">Coinbase Transaction</span>.</p>

                <h3>Impact on Mining Economics</h3>

                <p>A change in the subsidy can significantly affect hardware profitability. If the subsidy decreases, the miner receives fewer new coins per block, all else being equal.</p>

                <p>However, the impact of a lower subsidy may be partially offset by higher transaction fees, changes in the asset\'s price, or changes in network competition. Therefore, profitability should be evaluated based on the total <span class="term" data-term="mining/block-reward">block reward</span>, rather than the subsidy alone.</p>',
            ],

            'coinbase-transaction' => [
                'title' => 'What Is a Coinbase Transaction | TM Wiki',
                'description' => 'A Coinbase Transaction is a special block transaction through which the subsidy and fees payable to the miner are recorded.',
                'name' => 'Coinbase Transaction',
                'caption' => 'A special transaction created when a block is formed to receive the reward specified by the protocol.',
                'definition' => '<p><strong>Coinbase Transaction</strong> is a special transaction created when a new block is formed to record a payment to the block creator. Despite its name, it is not related to a regular transfer of funds between two users.</p>

                <h3>Features of a Coinbase Transaction</h3>

                <p>A Coinbase Transaction is created by the participant forming the block rather than being submitted by a network user. It may contain an amount corresponding to the <span class="term" data-term="mining/block-subsidy">block subsidy</span>, as well as the portion of transaction fees permitted by the protocol.</p>

                <p>This transaction is typically the first transaction in a block. Its structure and formation rules depend on the specific blockchain.</p>

                <h3>Relationship with the Reward</h3>

                <p>The primary function of a Coinbase Transaction is to record the <span class="term" data-term="mining/block-reward">block reward</span>. If a block contains an invalid amount or violates the protocol rules, it may be rejected by the network.</p>

                <p>Therefore, the maximum payment amount is not arbitrary. A miner cannot simply specify any desired amount: the permitted values are determined by the blockchain rules.</p>

                <h3>Difference from a Regular Transaction</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Characteristic</th>
                            <th>Coinbase Transaction</th>
                            <th>Regular Transaction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Creator</td>
                            <td>Participant forming the block</td>
                            <td>Network user</td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td>Recording the reward and related payments</td>
                            <td>Transfer of assets</td>
                        </tr>
                        <tr>
                            <td>Position in the block</td>
                            <td>Typically the first transaction</td>
                            <td>Any valid position</td>
                        </tr>
                    </tbody>
                </table>

                <p>The Coinbase Transaction is an important part of the economic incentive mechanism of <span class="term" data-term="mining/mining">mining</span>, because it is through this transaction that the protocol records the payment to the participant who created a new block.</p>',
            ],
        ],
    ],

    'mining-equipment' => [
        'title' => 'Mining Equipment Terms',
        'description' => 'Mining equipment glossary covering ASICs, hashboards, controllers, rigs, PDUs, noise boxes and other terms.',
        'name' => 'Mining Equipment',
        'caption' => 'Terms related to cryptocurrency mining equipment, including ASICs, hashboards, controllers, rigs, power infrastructure and specialized hardware.',
        'terms' => [
            'asic' => [
                'title' => 'What Is an ASIC in Mining | TM Wiki',
                'description' => 'ASIC is a specialized chip designed to perform computations for a specific algorithm. In mining, it provides high computational performance.',
                'name' => 'ASIC',
                'caption' => 'A specialized chip designed to perform computations for a specific algorithm.',
                'definition' => '<p><strong>ASIC</strong> (Application-Specific Integrated Circuit) is a specialized integrated circuit designed to perform a specific type of computation. In cryptocurrency mining, ASICs are used for algorithms that their hardware architecture is specifically optimized for.</p>

                <p>Unlike general-purpose processors and graphics processors, an ASIC is not designed for a wide range of tasks. Its architecture is optimized for a specific algorithm, allowing the device to provide high performance with relatively low power consumption per unit of computational power.</p>

                <h3>How ASICs Are Used in Mining</h3>

                <p>In <span class="term" data-term="mining/mining">mining</span>, an ASIC performs the computations required for the network to participate in the block validation process. For example, an ASIC for SHA-256 is optimized for computations using this algorithm and is not a general-purpose device for arbitrary algorithms.</p>

                <p>The practical characteristics of an ASIC are evaluated based on <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, and <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>.</p>

                <h3>Key Features</h3>
                <ul>
                <li>specialized for a specific algorithm;</li>
                <li>high computational performance for the supported algorithm;</li>
                <li>power consumption optimized relative to performance;</li>
                <li>limited applicability beyond the original algorithm;</li>
                <li>the need for effective heat dissipation under high load.</li>
                </ul>

                <p>ASICs form the basis of most modern specialized mining devices for algorithms with an established specialized hardware ecosystem.</p>'
            ],

            'asic-miner' => [
                'title' => 'What Is an ASIC Miner | TM Wiki',
                'description' => 'An ASIC miner is a ready-to-use cryptocurrency mining device based on specialized chips designed for a specific algorithm.',
                'name' => 'ASIC Miner',
                'caption' => 'A ready-to-use mining device based on specialized ASIC chips.',
                'definition' => '<p><strong>ASIC miner</strong> is a specialized device for <span class="term" data-term="mining/mining">mining</span> built around one or more <span class="term" data-term="mining-equipment/asic">ASIC</span> chips. The device contains not only computational chips, but also power, control, cooling, and network components.</p>

                <h3>What an ASIC Miner Consists Of</h3>

                <p>A typical design includes hashboards with ASIC chips, a control board, power supplies or an integrated power system, fans, and heat dissipation components. The specific architecture depends on the model and the algorithm being used.</p>

                <h3>Important Parameters</h3>
                <ul>
                <li><strong>Hashrate</strong> — the device\'s computational performance.</li>
                <li><strong>Power consumption</strong> — the amount of power required by the device during operation.</li>
                <li><strong>Power efficiency</strong> — the ratio of performance to power consumption.</li>
                <li><strong>Operating temperature</strong> — the temperature range within which the device is designed to operate reliably.</li>
                <li><strong>Noise level</strong> — the acoustic load, which is particularly important when the equipment is installed indoors.</li>
                </ul>

                <p>The economic performance of an ASIC miner depends not only on the characteristics of the device itself, but also on the price of the mined cryptocurrency, network difficulty, block reward, pool fee, and electricity cost.</p>

                <p>For continuous operation, multiple ASIC miners are typically considered part of a mining rig or a larger <span class="term" data-term="mining-infrastructure/mining-farm">mining farm</span>.</p>'
            ],

            'fpga-miner' => [
                'title' => 'What Is an FPGA Miner | TM Wiki',
                'description' => 'An FPGA miner uses programmable logic circuits for specialized computations and can be configured for different algorithms.',
                'name' => 'FPGA Miner',
                'caption' => 'A mining device based on a programmable FPGA logic array.',
                'definition' => '<p><strong>FPGA miner</strong> is a specialized computing device that uses an FPGA (Field-Programmable Gate Array) to execute mining algorithms. An FPGA is a programmable logic array whose configuration can be changed after the chip has been manufactured.</p>

                <p>In terms of architecture, FPGA occupies an intermediate position between general-purpose hardware and <span class="term" data-term="mining-equipment/asic">ASIC</span>. Unlike an ASIC, an FPGA can be reprogrammed for different computational logic, but effective use requires developing or configuring the appropriate hardware implementation.</p>

                <h3>Features of FPGA Mining</h3>
                <ul>
                <li>programmable hardware logic;</li>
                <li>the ability to adapt to different algorithms;</li>
                <li>potentially high power efficiency;</li>
                <li>more complex configuration compared with ready-to-use GPU hardware;</li>
                <li>performance that depends on the quality of the algorithm\'s hardware implementation.</li>
                </ul>

                <p>FPGAs are used when specialized computational acceleration is required, but using a completely fixed ASIC architecture is undesirable or economically impractical.</p>'
            ],

            'cpu-miner' => [
                'title' => 'What Is a CPU Miner | TM Wiki',
                'description' => 'A CPU miner uses a central processing unit for cryptocurrency mining computations and is suitable for algorithms designed for CPUs.',
                'name' => 'CPU Miner',
                'caption' => 'Mining hardware or software that uses a central processing unit for computation.',
                'definition' => '<p><strong>CPU miner</strong> is a system for <span class="term" data-term="mining/mining">mining</span> in which computations are performed by a central processing unit (CPU). Depending on the context, the term can refer either to a computer hardware configuration or to software that performs computations on the processor.</p>

                <p>A CPU is a general-purpose computing device and is well suited to algorithms that use general-purpose computing capabilities, large amounts of cache memory, or specific characteristics of CPU architectures.</p>

                <h3>Characteristics of CPU Mining</h3>

                <p>Performance depends on the processor architecture, the number and characteristics of its cores, clock frequency, cache capacity, power consumption settings, and the specific algorithm. Therefore, the number of cores alone does not determine mining efficiency.</p>

                <p>Compared with GPUs and specialized <span class="term" data-term="mining-equipment/asic">ASICs</span>, CPU efficiency strongly depends on the selected algorithm. For some algorithms, CPUs may remain a suitable type of hardware, while for others, specialized devices provide significantly higher performance.</p>'
            ],

            'gpu-rig' => [
                'title' => 'What Is a GPU Rig in Mining | TM Wiki',
                'description' => 'A GPU rig is a mining setup with multiple graphics cards combined to perform computations together.',
                'name' => 'GPU Rig',
                'caption' => 'A mining setup that combines multiple graphics processors.',
                'definition' => '<p><strong>GPU rig</strong> is a type of mining rig in which multiple graphics processors operate simultaneously under the control of a single system.</p>

                <p>The main purpose of a GPU rig is to combine multiple graphics cards into a single computing configuration. GPUs are connected to the motherboard through appropriate interfaces, and stable operation requires sufficient electrical power and effective cooling.</p>

                <h3>Typical GPU Rig Structure</h3>
                <ul>
                <li>multiple graphics cards;</li>
                <li>motherboard;</li>
                <li>central processing unit;</li>
                <li>RAM;</li>
                <li>storage device;</li>
                <li>one or more power supplies;</li>
                <li>frame;</li>
                <li>cooling components.</li>
                </ul>

                <p>When a large number of graphics cards are used, <span class="term" data-term="mining-equipment/riser">risers</span> may be used to physically position GPUs away from the motherboard and simplify the rig\'s layout.</p>

                <p>GPU rig configuration includes selecting clock frequencies, power limits, and memory parameters. <span class="term" data-term="equipment-specifications/undervolting">Undervolting</span> and <span class="term" data-term="equipment-specifications/underclocking">underclocking</span> can be used to reduce power consumption.</p>'
            ],

            'mining-hardware' => [
                'title' => 'What Is Mining Hardware | TM Wiki',
                'description' => 'Mining hardware includes computing devices and the components required to power, cool, and control them.',
                'name' => 'Mining Hardware',
                'caption' => 'A collection of hardware used to perform mining computations.',
                'definition' => '<p><strong>Mining hardware</strong> is a collection of hardware components designed to perform computations during <span class="term" data-term="mining/mining">mining</span>. It includes both computing devices themselves and components that provide power, cooling, control, and physical mounting.</p>

                <h3>Main Types of Computing Hardware</h3>
                <ul>
                <li><span class="term" data-term="mining-equipment/asic">ASICs</span> and <span class="term" data-term="mining-equipment/asic-miner">ASIC miners</span>;</li>
                <li><span class="term" data-term="mining-equipment/gpu-rig">GPU rigs</span>;</li>
                <li><span class="term" data-term="mining-equipment/fpga-miner">FPGA miners</span>;</li>
                <li><span class="term" data-term="mining-equipment/cpu-miner">CPU miners</span>.</li>
                </ul>

                <h3>Supporting Components</h3>

                <p>Full operation of computing hardware requires power supplies, risers, control boards, cooling systems, and mounting structures. The specific set of components depends on the type of miner and the scale of the setup.</p>

                <p>When selecting hardware, <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>, operating temperature, and power supply requirements are evaluated.</p>

                <p>Hardware is part of the overall mining infrastructure, which also includes power supply, networking, cooling, and control systems.</p>'
            ],

            'hashboard' => [
                'title' => 'What Is a Hashboard in an ASIC Miner | TM Wiki',
                'description' => 'A hashboard is the computing board of an ASIC miner containing chips that perform the main hash calculations.',
                'name' => 'Hashboard',
                'caption' => 'The computing board of an ASIC miner that contains specialized chips.',
                'definition' => '<p><strong>Hashboard</strong> is the computing board of a specialized miner that contains <span class="term" data-term="mining-equipment/asic">ASIC</span> chips responsible for performing the main computations of the mining algorithm.</p>

                <p>In many ASIC miner designs, multiple hashboards are connected to a single control board and power system. Each board is responsible for part of the device\'s total computational performance.</p>

                <h3>The Role of a Hashboard</h3>

                <p>A hashboard contains computing chips and the components required for their operation. The board receives power and control signals, performs computations, and sends the results to the control system.</p>

                <p>Failure of one hashboard usually results in a reduction of the miner\'s overall <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>. Therefore, when diagnosing ASIC equipment, the condition of each computing board and its associated components is checked separately.</p>

                <h3>Main Parameters</h3>
                <ul>
                <li>number of ASIC chips;</li>
                <li>chip architecture and generation;</li>
                <li>operating frequency;</li>
                <li>temperature;</li>
                <li>computational stability;</li>
                <li>number of hardware errors.</li>
                </ul>

                <p>A hashboard should be distinguished from the <span class="term" data-term="mining-equipment/control-board">control board</span>: the hashboard performs the computational work, while the control board manages the miner and provides interaction between its components and the software.</p>'
            ],

            'control-board' => [
                'title' => 'What Is a Miner Control Board | TM Wiki',
                'description' => 'A control board coordinates the operation of computing boards, networking, power, and software in a mining device.',
                'name' => 'Control Board',
                'caption' => 'A controller that manages the computing and supporting components of a miner.',
                'definition' => '<p><strong>Control board</strong> is an electronic controller in a mining device that coordinates the operation of computing boards and other components. In an ASIC miner, it typically interacts with hashboards, the cooling system, the network interface, and the software.</p>

                <h3>Main Functions</h3>
                <ul>
                <li>starting and stopping computing boards;</li>
                <li>monitoring operating parameters;</li>
                <li>sending tasks to computing chips;</li>
                <li>receiving and processing computation results;</li>
                <li>providing a network connection to a mining pool or another source of tasks;</li>
                <li>controlling fans and monitoring temperature.</li>
                </ul>

                <p>The control board does not perform the main volume of hashing. Computations are performed by specialized components, such as ASIC chips on <span class="term" data-term="mining-equipment/hashboard">hashboards</span>.</p>

                <p>If the control board fails, the miner may completely lose network connectivity, stop starting the computing boards, or incorrectly display their status, even when the hashboards themselves are functioning properly.</p>'
            ],

            'riser' => [
                'title' => 'What Is a Riser in Mining | TM Wiki',
                'description' => 'A riser allows a graphics card to be connected to the motherboard at a distance and is used to build multi-GPU rigs.',
                'name' => 'Riser',
                'caption' => 'An adapter for connecting a graphics card to a motherboard remotely.',
                'definition' => '<p><strong>Riser</strong> is an adapter used to connect a graphics card to a motherboard at a distance. In <span class="term" data-term="mining-equipment/gpu-rig">GPU rigs</span>, risers allow multiple graphics cards to be positioned separately from the motherboard, simplifying the physical layout of the equipment.</p>

                <h3>Why a Riser Is Needed</h3>

                <p>When multiple GPUs are used, it is often impossible to install all graphics cards directly into the motherboard slots because of their size and cooling requirements. Risers allow the graphics cards to be positioned separately and connected to the system through a cable.</p>

                <p>A typical design includes an adapter board, a data transmission cable, and a separate power connector. The specific implementation depends on the interface being used and the hardware generation.</p>

                <h3>Operating Considerations</h3>

                <p>A riser is an additional connection point, so its condition can affect GPU operating stability. A faulty or improperly connected riser can cause the system to lose a graphics card, generate hardware errors, or experience intermittent disconnections.</p>

                <p>When diagnosing a GPU rig, the riser\'s power supply, connection to the motherboard, and cable condition are checked.</p>'
            ],
        ],
    ],

    'equipment-specifications' => [
        'title' => 'Mining Equipment Specifications',
        'description' => 'Glossary of ASIC and mining equipment specifications: hashrate, efficiency, uptime, overclocking and other terms.',
        'name' => 'Equipment Specifications',
        'caption' => 'Terms and metrics describing mining equipment, including hashrate, energy efficiency, power consumption, uptime, overclocking and other specifications.',
        'terms' => [
            'hashrate' => [
                'title' => 'What Is Hashrate in Mining | TM Wiki',
                'description' => 'Hashrate indicates the computational performance of a miner and is measured in hashes per second according to the algorithm being used.',
                'name' => 'Hashrate',
                'caption' => 'The number of hash function calculations that equipment can perform per unit of time.',
                'definition' => '<p><strong>Hashrate</strong> is a measure of the computational performance of mining equipment or a network, expressed as the number of hashes calculated per unit of time. In <span class="term" data-term="mining/mining">mining</span>, hashrate indicates how quickly equipment performs calculations for the algorithm being used.</p>

                <p>The unit of measurement is hashes per second (H/s). Modern equipment is usually described using derived units: KH/s, MH/s, GH/s, TH/s, PH/s, and EH/s. For example, 1 TH/s means one trillion calculations per second.</p>

                <h3>Equipment Hashrate</h3>

                <p>The nominal hashrate depends on the type of equipment, the algorithm being used, and the operating mode. For an <span class="term" data-term="mining-equipment/asic-miner">ASIC miner</span>, performance is usually specified in TH/s or PH/s, while for a <span class="term" data-term="mining-equipment/gpu-rig">GPU miner</span>, the unit depends on the algorithm and may be expressed in MH/s or GH/s.</p>

                <p>Actual hashrate may differ from the manufacturer\'s stated value. It is affected by <span class="term" data-term="equipment-specifications/clock-frequency">clock frequency</span>, equipment settings, temperature, <span class="term" data-term="equipment-specifications/power-limit">power limit</span>, <span class="term" data-term="equipment-specifications/thermal-throttling">thermal throttling</span>, power stability, and the number of <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>.</p>

                <h3>Hashrate and Energy Efficiency</h3>

                <p>High hashrate alone does not determine equipment efficiency. For economic evaluation, it is considered together with <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span> and <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>.</p>

                <h3>Network Hashrate</h3>

                <p>In networks using <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, the concept of total network hashrate is also used. It represents the combined computational power of miners participating in maintaining the network. Changes in network hashrate affect the distribution of computational competition among participants and are related to the <span class="term" data-term="blockchain/consensus-mechanism">consensus mechanism</span> and mining difficulty adjustment process.</p>'
            ],

            'power-consumption' => [
                'title' => 'Miner Power Consumption | TM Wiki',
                'description' => 'Power consumption shows how much power a miner uses during operation and directly affects electricity costs.',
                'name' => 'Power Consumption',
                'caption' => 'The amount of electrical power consumed by mining equipment during operation.',
                'definition' => '<p><strong>Power consumption</strong> is the amount of electrical power that equipment uses during operation. In mining, this parameter is usually expressed in watts (W) or kilowatts (kW) and is one of the key factors in calculating operating expenses.</p>

                <p>Power consumption depends on the device design, algorithm, workload, <span class="term" data-term="equipment-specifications/clock-frequency">clock frequency</span>, voltage settings, and <span class="term" data-term="equipment-specifications/power-limit">power limit</span>. In ASIC miners, a significant portion of consumption comes from the computing boards and cooling system.</p>

                <h3>Power Consumption and Electricity Costs</h3>

                <p>When operating continuously, power can be converted into energy consumption over a specific period. For example, equipment rated at 1 kW operating for 24 hours consumes 24 kWh per day if its actual power remains constant.</p>

                <p>The cost of this electricity is determined by the electricity tariff. Therefore, the same miner can have different economic performance depending on the cost of electricity.</p>

                <h3>Power Consumption and Efficiency</h3>

                <p>Consumption cannot be evaluated separately from performance. <span class="term" data-term="equipment-specifications/power-efficiency">Power efficiency</span> are used to compare equipment.</p>

                <p>Reducing consumption while maintaining sufficient hashrate can improve the economic efficiency of equipment. Methods such as <span class="term" data-term="equipment-specifications/undervolting">undervolting</span>, <span class="term" data-term="equipment-specifications/underclocking">underclocking</span>, and power limiting can be used for this purpose.</p>

                <h3>Other Factors to Consider</h3>

                <ul>
                <li>peak and actual power consumption;</li>
                <li>consumption of the computing equipment and auxiliary systems;</li>
                <li>load on the electrical infrastructure;</li>
                <li>heat generation;</li>
                <li>the impact of temperature and cooling conditions on operational stability.</li>
                </ul>

                <p>Almost all electrical energy consumed by a miner is ultimately converted into heat, so power calculations are also part of calculating the <span class="term" data-term="cooling/thermal-load">thermal load</span> of the cooling system.</p>'
            ],

            'power-efficiency' => [
                'title' => 'What Is Miner Power Efficiency | TM Wiki',
                'description' => 'Miner power efficiency shows how much computational power equipment produces for each unit of electrical power consumed.',
                'name' => 'Power Efficiency',
                'caption' => 'The ratio between the computational performance of equipment and the electrical power it consumes.',
                'definition' => '<p><strong>Power efficiency</strong> is a characteristic of equipment that shows how much computational work it performs relative to the electrical power it consumes. In mining, power efficiency is particularly important because electricity is one of the main <span class="term" data-term="mining-economics/opex">operating expenses</span>.</p>

                <p>For ASIC equipment, power efficiency is often expressed in J/TH — joules per terahash. The lower the J/TH value, the less energy is required to produce one terahash of computational power.</p>

                <h3>Calculation</h3>

                <p>If a device consumes 3000 W and provides 200 TH/s, its specific energy consumption is:</p>

                <p><strong>3000 / 200 = 15 J/TH.</strong></p>

                <p>The same characteristic can be represented through hashrate per watt. These indicators describe the same relationship between performance and power consumption but use different units of measurement.</p>

                <h3>What Determines Power Efficiency</h3>

                <ul>
                <li>the technological generation of the computing chips;</li>
                <li>equipment architecture;</li>
                <li><span class="term" data-term="equipment-specifications/clock-frequency">clock frequency</span>;</li>
                <li>supply voltage;</li>
                <li><span class="term" data-term="equipment-specifications/power-limit">power limit</span>;</li>
                <li>component temperature;</li>
                <li>cooling mode;</li>
                <li>equipment optimization settings.</li>
                </ul>

                <p>When the operating mode changes, hashrate and power consumption may not change proportionally. Therefore, reducing frequency and voltage can sometimes significantly reduce power consumption while causing a relatively small decrease in performance.</p>

                <p>Power efficiency is directly related to the cost of electricity and <span class="term" data-term="mining-economics/mining-profitability">mining profitability</span>. The higher the electricity cost, the more significant the impact of equipment efficiency on the economic result.</p>'
            ],

            'power-limit' => [
                'title' => 'What Is a Miner Power Limit | TM Wiki',
                'description' => 'A Power Limit restricts the maximum power consumption of a miner and is used to manage performance, temperature, and energy usage.',
                'name' => 'Power Limit',
                'caption' => 'A restriction on the maximum electrical power available to equipment during operation.',
                'definition' => '<p><strong>Power Limit</strong> is a setting that restricts the maximum electrical power consumed by computing equipment. It is used to manage the relationship between <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, power consumption, and temperature.</p>

                <p>When the power limit is reduced, the equipment receives less energy for performing computations. Depending on the device architecture, this may result in a reduction in <span class="term" data-term="equipment-specifications/clock-frequency">operating frequency</span>, hashrate, and temperature.</p>

                <h3>Why Power Limit Is Used</h3>

                <ul>
                <li>limiting power consumption;</li>
                <li>reducing component temperatures;</li>
                <li>reducing the load on the power supply and electrical infrastructure;</li>
                <li>optimizing <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>;</li>
                <li>matching equipment to the available electrical capacity.</li>
                </ul>

                <p>Reducing the power limit does not always result in a proportional decrease in performance. The exact effect depends on the chip architecture and the current operating mode.</p>

                <h3>Relationship to Other Settings</h3>

                <p>Power Limit is often used together with <span class="term" data-term="equipment-specifications/undervolting">undervolting</span>, <span class="term" data-term="equipment-specifications/underclocking">underclocking</span>, and <span class="term" data-term="equipment-specifications/overclocking">overclocking</span>. These parameters make it possible to select an operating point between performance, power consumption, and temperature.</p>

                <p>For stable operation, it is necessary to consider not only the configured limit but also actual power consumption, temperature, and the number of <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>.</p>'
            ],

            'operating-temperature' => [
                'title' => 'Miner Operating Temperature: What Is It | TM Wiki',
                'description' => 'Operating temperature describes the thermal conditions under which mining equipment operates and affects component stability and service life.',
                'name' => 'Operating Temperature',
                'caption' => 'The temperature range within which equipment is designed to operate reliably.',
                'definition' => '<p><strong>Operating temperature</strong> is a temperature parameter describing the conditions under which mining equipment is designed to operate normally. Different components may have different temperature ranges and maximum permissible values.</p>

                <p>Temperature affects computational stability, power consumption, cooling system operation, and long-term equipment operation. Therefore, when designing an installation, it is necessary to consider not only the temperature of the chips themselves but also ambient temperature, inlet air temperature, and the effectiveness of heat removal.</p>

                <h3>Temperature and Performance</h3>

                <p>When excessive heating occurs, equipment may automatically reduce its operating parameters. This mechanism is called <span class="term" data-term="equipment-specifications/thermal-throttling">thermal throttling</span>. It helps limit the thermal load but can simultaneously reduce <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>.</p>

                <p>Temperature is monitored using sensors installed directly on components or inside the equipment. In ASIC miners, the temperature of the computing chips is monitored separately because they generate a significant portion of the thermal load.</p>

                <h3>Relationship to Cooling</h3>

                <p>Maintaining the operating temperature depends on the <span class="term" data-term="cooling/cooling-loop">cooling system</span> and its ability to remove the generated heat. In air-cooled systems, inlet air temperature and airflow are particularly important. In liquid-cooled systems, coolant parameters and the temperature difference between the inlet and outlet are also monitored.</p>

                <p>Other parameters used to assess operating conditions include <span class="term" data-term="equipment-specifications/chip-temperature">chip temperature</span>, <span class="term" data-term="equipment-specifications/operating-temperature">operating temperature</span>, and environmental conditions.</p>'
            ],

            'chip-temperature' => [
                'title' => 'What Is Miner Chip Temperature | TM Wiki',
                'description' => 'Chip temperature indicates the heating of computing chips during operation and is used to monitor the condition of a miner.',
                'name' => 'Chip Temperature',
                'caption' => 'The temperature of a computing chip while mining equipment is operating.',
                'definition' => '<p><strong>Chip temperature</strong> is the temperature of a computing chip while equipment is operating. In mining, this metric is used to monitor the thermal condition of ASICs, GPUs, and other computing components.</p>

                <p>Chip temperature is determined by electrical power, operating frequency, voltage, workload, and the effectiveness of heat removal. Therefore, changing the <span class="term" data-term="equipment-specifications/power-limit">power limit</span>, <span class="term" data-term="equipment-specifications/clock-frequency">frequency</span>, or cooling parameters can directly affect temperature.</p>

                <h3>Why Temperature Matters</h3>

                <p>Excessive heating can lead to reduced performance, an increase in <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>, and activation of <span class="term" data-term="equipment-specifications/thermal-throttling">thermal throttling</span>. However, low temperature by itself is not a separate measure of efficiency: stable operation within the permissible range is more important.</p>

                <h3>Temperature Monitoring</h3>

                <p>Chip temperature is monitored using equipment sensors and miner management software. When specified thresholds are exceeded, the system may automatically adjust frequencies, fan speeds, or other parameters.</p>

                <p>Various cooling technologies are used to maintain chip temperature, including air, liquid, and immersion cooling. Their effectiveness also depends on <span class="term" data-term="cooling/heat-dissipation">heat dissipation</span> and <span class="term" data-term="cooling/thermal-load">thermal load</span>.</p>'
            ],

            'chip-count' => [
                'title' => 'Miner Chip Count: What Is It | TM Wiki',
                'description' => 'Chip count indicates how many computing chips are installed in a miner and is a characteristic of its hardware architecture.',
                'name' => 'Chip Count',
                'caption' => 'The number of computing chips installed in mining equipment.',
                'definition' => '<p><strong>Chip count</strong> is the number of computing chips installed in mining equipment. In ASIC miners, this usually refers to the number of specialized ASIC chips installed on the computing boards.</p>

                <p>Chip count is a characteristic of the hardware architecture but does not by itself determine device performance. Two miners with the same number of chips can differ significantly in <span class="term" data-term="equipment-specifications/hashrate">hashrate</span> and <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>.</p>

                <h3>Relationship to ASIC Architecture</h3>

                <p>Performance depends on chip generation, internal architecture, operating <span class="term" data-term="equipment-specifications/clock-frequency">frequency</span>, and manufacturing process. Therefore, when comparing equipment, it is necessary to consider not only the number of chips but also the characteristics of each chip.</p>

                <p>Chips are typically distributed across several <span class="term" data-term="mining-equipment/hashboard">hashboards</span>. Failure of some chips can lead to reduced overall hashrate, the appearance of <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>, or the shutdown of an individual computing board.</p>'
            ],

            'chip-generation' => [
                'title' => 'Chip Generation in Mining: What Is It | TM Wiki',
                'description' => 'Chip generation describes the technological and architectural version of computing chips and affects miner performance.',
                'name' => 'Chip Generation',
                'caption' => 'The technological and architectural generation of computing chips used in equipment.',
                'definition' => '<p><strong>Chip generation</strong> is a characteristic describing the technological and architectural version of the computing chips used in mining equipment. For ASICs, a transition to a new chip generation is usually associated with changes in architecture, manufacturing process, and power efficiency.</p>

                <p>A newer generation does not automatically mean that all characteristics will improve. To evaluate specific equipment, it is necessary to consider a combination of parameters: <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>, operating temperatures, and other characteristics.</p>

                <h3>Relationship to the Manufacturing Process</h3>

                <p>Reducing manufacturing process node size can make it possible to place more computing logic in the same area and reduce the energy required for individual operations. However, final characteristics depend not only on transistor size but also on architecture, circuit design, frequencies, and power management.</p>

                <p>Chips of a particular generation can operate in different modes. Changes to <span class="term" data-term="equipment-specifications/clock-frequency">frequency</span>, voltage, and <span class="term" data-term="equipment-specifications/power-limit">power limit</span> affect actual hashrate and power consumption.</p>'
            ],

            'memory-capacity' => [
                'title' => 'What Is Miner Memory Capacity | TM Wiki',
                'description' => 'Memory capacity indicates the amount of available RAM or specialized memory and is important for algorithms with high memory requirements.',
                'name' => 'Memory Capacity',
                'caption' => 'The amount of memory available to a computing device for storing data during operation.',
                'definition' => '<p><strong>Memory capacity</strong> is the amount of memory available to a computing device for storing data while an algorithm is running. It is usually expressed in megabytes or gigabytes.</p>

                <p>For <span class="term" data-term="mining-equipment/gpu-rig">GPU mining</span>, video memory capacity can be a critical limitation. Some algorithms require a large dataset to be stored in memory, and if the available capacity is insufficient, the GPU cannot efficiently perform the corresponding computations.</p>

                <h3>Memory Capacity and Algorithms</h3>

                <p>Memory requirements are determined by the architecture of a specific algorithm. Depending on its design, not only capacity but also <span class="term" data-term="equipment-specifications/memory-bandwidth">memory bandwidth</span>, latency, and data access patterns can be important.</p>

                <p>If the required dataset exceeds available memory, increasing the computational power of the device does not solve the problem. Therefore, when selecting equipment, the algorithm\'s requirements should be matched with the memory specifications.</p>

                <p>For ASIC devices, memory requirements are determined by the specific hardware implementation of the algorithm. In some ASIC designs, memory plays a supporting role, while in others its characteristics may be a significant performance constraint.</p>'
            ],

            'memory-bandwidth' => [
                'title' => 'What Is Memory Bandwidth | TM Wiki',
                'description' => 'Memory bandwidth indicates the speed of data transfer between computing units and memory and is important for certain mining algorithms.',
                'name' => 'Memory Bandwidth',
                'caption' => 'The amount of data that memory can transfer per unit of time.',
                'definition' => '<p><strong>Memory bandwidth</strong> is the maximum amount of data that memory can transfer between memory and computing units per unit of time. It is usually expressed in GB/s.</p>

                <p>In mining, memory bandwidth is particularly important for algorithms whose performance is limited by the speed of data access. In such cases, increasing computational power without a corresponding increase in memory speed may not result in a proportional increase in <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>.</p>

                <h3>Memory Bandwidth and Capacity</h3>

                <p><span class="term" data-term="equipment-specifications/memory-capacity">Memory capacity</span> and memory bandwidth describe different characteristics. Large capacity allows more data to be stored, while high bandwidth allows data to be transferred more quickly between memory and computing units.</p>

                <p>For GPU miners, both parameters can affect performance. Their specific importance depends on the algorithm and its characteristics.</p>

                <h3>Impact of Frequency</h3>

                <p>Bandwidth depends on the type of memory, bus width, and effective memory frequency. Therefore, increasing <span class="term" data-term="equipment-specifications/clock-frequency">memory frequency</span> can increase available bandwidth if other components do not become the limiting factor.</p>

                <p>Changing memory parameters can also affect power consumption and temperature, so <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span> and thermal load must be considered when configuring equipment.</p>'
            ],

            'clock-frequency' => [
                'title' => 'What Is Miner Clock Frequency | TM Wiki',
                'description' => 'Clock frequency determines the operating speed of computing components and affects equipment hashrate, power consumption, and temperature.',
                'name' => 'Clock Frequency',
                'caption' => 'The frequency of clock cycles performed by a computing component, representing one of the factors that determine its performance.',
                'definition' => '<p><strong>Clock frequency</strong> is the number of clock cycles performed by a computing component per second. It is usually expressed in MHz or GHz and is one of the parameters that determine equipment performance.</p>

                <p>In mining, changing frequency can affect <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, and <span class="term" data-term="equipment-specifications/chip-temperature">chip temperature</span>. However, the relationship is not universally linear and depends on the equipment architecture and algorithm.</p>

                <h3>Frequency and Overclocking</h3>

                <p>Increasing the frequency above standard values is called <span class="term" data-term="equipment-specifications/overclocking">overclocking</span>. It can increase performance but may also increase power consumption, temperature, and the likelihood of <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>.</p>

                <p>Reducing the frequency is called <span class="term" data-term="equipment-specifications/underclocking">underclocking</span>. It is used to reduce power consumption and heat generation or to find a more suitable operating mode.</p>

                <h3>Relationship to Voltage</h3>

                <p>Frequency is closely related to supply voltage. In some systems, reducing voltage together with frequency can reduce power consumption. This approach is known as <span class="term" data-term="equipment-specifications/undervolting">undervolting</span>.</p>

                <p>If the temperature becomes too high, the system may automatically reduce frequency through <span class="term" data-term="equipment-specifications/thermal-throttling">thermal throttling</span>, resulting in lower actual hashrate.</p>'
            ],

            'uptime' => [
                'title' => 'What Is Mining Uptime | TM Wiki',
                'description' => 'Uptime shows the amount of time during which mining equipment or a system is operating and available for computation.',
                'name' => 'Uptime',
                'caption' => 'A measure of the time during which mining equipment operates continuously and remains available.',
                'definition' => '<p><strong>Uptime</strong> is a measure of the time during which mining equipment or a system is operating and available for computation. It is usually expressed in hours, days, or as a percentage of a given observation period.</p>

                <p>Uptime is important in mining because equipment produces computational output only while it is actually operating. Restarts, failures, power problems, network issues, or cooling problems reduce actual operating time.</p>

                <h3>Uptime Calculation</h3>

                <p>If equipment operated for 720 hours out of 744, uptime is:</p>

                <p><strong>720 / 744 × 100% ≈ 96.8%.</strong></p>

                <p>When evaluating stability, the duration of the measurement period should be considered. Short-term uptime over several hours does not provide enough information to assess long-term equipment reliability.</p>

                <h3>Factors Affecting Uptime</h3>

                <ul>
                <li>equipment reliability;</li>
                <li>power supply stability;</li>
                <li>the quality of the network infrastructure;</li>
                <li>temperature conditions;</li>
                <li>the cooling system;</li>
                <li>the quality of software and management systems;</li>
                <li>the speed of detecting and resolving failures.</li>
                </ul>

                <p>High uptime does not mean that individual errors are absent: a device may continue operating while experiencing reduced hashrate or hardware errors. Therefore, uptime should ideally be analyzed together with actual <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, temperature, and equipment status.</p>'
            ],

            'overclocking' => [
                'title' => 'What Is Miner Overclocking | TM Wiki',
                'description' => 'Overclocking increases equipment operating frequencies to improve performance but can also increase power consumption and temperature.',
                'name' => 'Overclocking',
                'caption' => 'Increasing the operating frequencies of computing equipment above standard values.',
                'definition' => '<p><strong>Overclocking</strong> is the process of increasing the operating <span class="term" data-term="equipment-specifications/clock-frequency">frequency</span> of computing equipment above its standard operating values. In mining, overclocking is used to increase <span class="term" data-term="equipment-specifications/hashrate">hashrate</span> when the equipment and cooling system can operate reliably at higher settings.</p>

                <p>Depending on the equipment architecture and specific algorithm, overclocking may be applied to the frequency of computing chips or memory.</p>

                <h3>The Cost of Higher Frequency</h3>

                <p>Increasing frequency generally increases the load on computing components. Depending on the architecture, this can lead to higher <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, higher <span class="term" data-term="equipment-specifications/chip-temperature">chip temperature</span>, and an increase in <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>.</p>

                <p>If cooling is insufficient, <span class="term" data-term="equipment-specifications/thermal-throttling">thermal throttling</span> may be activated. In this case, actual hashrate may be lower than expected despite the higher configured frequency.</p>

                <h3>Overclocking and Power Efficiency</h3>

                <p>Maximum hashrate does not always correspond to the most efficient operating mode. For economic operation, the additional hashrate is compared with the additional power consumption, and changes in hashrate per watt are evaluated.</p>

                <p>Overclocking is often combined with adjustments to the <span class="term" data-term="equipment-specifications/power-limit">power limit</span> and <span class="term" data-term="equipment-specifications/undervolting">undervolting</span> to find a suitable balance between performance, temperature, and power consumption.</p>'
            ],

            'underclocking' => [
                'title' => 'What Is Miner Underclocking | TM Wiki',
                'description' => 'Underclocking reduces equipment operating frequency to lower power consumption, temperature, or component load.',
                'name' => 'Underclocking',
                'caption' => 'Reducing the operating frequency of computing equipment below its standard operating mode.',
                'definition' => '<p><strong>Underclocking</strong> is the process of reducing the operating <span class="term" data-term="equipment-specifications/clock-frequency">frequency</span> of computing equipment. In mining, it is used to reduce <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, heat generation, and component load.</p>

                <p>Reducing frequency generally results in lower <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, although the magnitude of the change depends on the algorithm and equipment architecture.</p>

                <h3>Why Underclocking Is Used</h3>

                <ul>
                <li>reducing power consumption;</li>
                <li>reducing chip temperature;</li>
                <li>reducing the load on the cooling system;</li>
                <li>limiting the total power of an installation;</li>
                <li>finding an operating mode with a suitable balance between hashrate and power consumption.</li>
                </ul>

                <p>Underclocking is often used together with <span class="term" data-term="equipment-specifications/undervolting">undervolting</span>. In this mode, both frequency and voltage can be reduced to lower power consumption.</p>

                <p>When configuring equipment, actual hashrate per watt, temperature, and the number of <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span> should be monitored. Excessive reduction of operating parameters can decrease performance more than it reduces operating costs.</p>'
            ],

            'undervolting' => [
                'title' => 'What Is Miner Undervolting | TM Wiki',
                'description' => 'Undervolting reduces the supply voltage of computing components to lower power consumption and temperature while maintaining stable operation.',
                'name' => 'Undervolting',
                'caption' => 'Reducing the supply voltage of computing components to optimize power consumption and heat generation.',
                'definition' => '<p><strong>Undervolting</strong> is the process of reducing the supply voltage of a computing component below its standard value while maintaining stable operation. In mining, this method is used to reduce <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span> and <span class="term" data-term="equipment-specifications/chip-temperature">chip temperature</span>.</p>

                <p>Power consumption in computing circuits depends on voltage and frequency. Therefore, reducing voltage can significantly reduce power consumption, especially when combined with <span class="term" data-term="equipment-specifications/underclocking">underclocking</span>.</p>

                <h3>Undervolting and Stability</h3>

                <p>Excessively low voltage can cause unstable operation of computing components, resulting in <span class="term" data-term="equipment-specifications/hardware-error">hardware errors</span>, reduced performance, or restarts.</p>

                <p>After changing voltage, actual <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, temperature, power consumption, and operational stability should therefore be monitored over a sufficient period.</p>

                <h3>Economic Meaning</h3>

                <p>The goal of undervolting is not necessarily to achieve the lowest possible power consumption. In practice, the objective is to find an operating point where the reduction in power is justified by the corresponding reduction in hashrate and results in improved <span class="term" data-term="equipment-specifications/power-efficiency">power efficiency</span>.</p>

                <p>The adjustment can also reduce the requirements for <span class="term" data-term="cooling/heat-dissipation">heat removal</span> and lower the load on the cooling system.</p>'
            ],

            'thermal-throttling' => [
                'title' => 'What Is Miner Thermal Throttling | TM Wiki',
                'description' => 'Thermal throttling automatically reduces equipment performance when it becomes too hot in order to limit temperature.',
                'name' => 'Thermal Throttling',
                'caption' => 'Automatic reduction of a computing component’s performance due to high temperature.',
                'definition' => '<p><strong>Thermal throttling</strong> is a mechanism that automatically reduces the performance of a computing component when it reaches a high temperature. It is designed to limit the thermal load and prevent operation outside the permissible temperature range.</p>

                <p>In mining, throttling may manifest as a reduction in <span class="term" data-term="equipment-specifications/clock-frequency">operating frequency</span>, voltage, or other parameters that determine performance. As a result, actual <span class="term" data-term="equipment-specifications/hashrate">hashrate</span> decreases.</p>

                <h3>Causes of Thermal Throttling</h3>

                <ul>
                <li>high <span class="term" data-term="equipment-specifications/chip-temperature">chip temperature</span>;</li>
                <li>insufficient cooling system performance;</li>
                <li>high ambient temperature;</li>
                <li>contamination or restricted airflow;</li>
                <li>excessive power and computational load;</li>
                <li>incorrect equipment settings.</li>
                </ul>

                <p>Throttling is not itself a malfunction: it is a protective mechanism. However, continuous operation in this mode may indicate a mismatch between the thermal load and the cooling system\'s capabilities or overly aggressive equipment settings.</p>

                <h3>How to Detect Throttling</h3>

                <p>Temperature, frequency, and actual hashrate are usually analyzed together. If frequency automatically decreases as temperature increases and performance falls, this may indicate that a thermal limit has been activated.</p>

                <p>To address the cause, the <span class="term" data-term="cooling/cooling-capacity">cooling system capacity</span>, airflow, inlet air temperature, and <span class="term" data-term="equipment-specifications/power-limit">power limit</span> settings should be checked.</p>'
            ],

            'hardware-error' => [
                'title' => 'What Is a Miner Hardware Error | TM Wiki',
                'description' => 'A hardware error indicates incorrect computation or equipment problems and helps identify unstable operating conditions.',
                'name' => 'Hardware Error',
                'caption' => 'An error associated with incorrect operation of computing equipment while performing computations.',
                'definition' => '<p><strong>A hardware error</strong> is an error that occurs when computing hardware performs calculations incorrectly. Such errors may be caused by unstable settings, overheating, power problems, faulty computing chips, or other component failures.</p>

                <h3>Causes of Hardware Errors</h3>

                <ul>
                <li>excessively high <span class="term" data-term="equipment-specifications/clock-frequency">clock frequency</span>;</li>
                <li>excessively low voltage after <span class="term" data-term="equipment-specifications/undervolting">undervolting</span>;</li>
                <li>excessive temperature;</li>
                <li>unstable power supply;</li>
                <li>physical failure of a computing chip;</li>
                <li>memory or connection problems;</li>
                <li>aggressive <span class="term" data-term="equipment-specifications/overclocking">overclocking</span> settings.</li>
                </ul>

                <p>A small number of errors does not necessarily indicate complete equipment failure, but a persistent increase in their number may indicate an unstable operating mode. It is also important to distinguish hardware errors from errors related to the network or <span class="term" data-term="mining-pools/share">shares</span> submitted to a mining pool.</p>

                <h3>Impact on Mining</h3>

                <p>Hardware errors can reduce actual performance, cause computational results to be rejected, or trigger restarts of individual components. Therefore, when configuring equipment, both the stated <span class="term" data-term="equipment-specifications/hashrate">hashrate</span> and the stability with which it is achieved should be evaluated.</p>

                <p>If errors appear after increasing frequency, reducing voltage, or changing the <span class="term" data-term="equipment-specifications/power-limit">power limit</span>, the parameters are usually returned to a stable operating mode and then adjusted gradually while monitoring temperature and performance.</p>'
            ],
        ],
    ],

    'mining-pools' => [
        'title' => 'Mining Pool Terms',
        'description' => 'Mining pool glossary covering shares, workers, PPS, PPLNS, FPPS, Stratum, pool luck and other terms.',
        'name' => 'Mining Pools',
        'caption' => 'Terms used in mining pools, including shares, workers, pool fees, payout systems, Stratum, pool luck and other concepts.',
        'terms' => [
            'mining-pool' => [
                'title' => 'What Is a Mining Pool | TM Wiki',
                'description' => 'A mining pool combines miners’ computing power, distributes work, and shares block rewards among participants.',
                'name' => 'Mining Pool',
                'caption' => 'Infrastructure for combining miners, distributing computational work, and calculating payouts.',
                'definition' => '<p><strong>Mining Pool</strong> is server infrastructure and an accounting system that combines the computing power of multiple participants for collaborative mining. Instead of each miner independently waiting to find a block and potentially receiving no income for a long period, participants connect to a shared pool and regularly submit the results of their computational work.</p>

                <p>The pool does not physically combine the mining devices. Each miner continues performing computations on its own hardware, while the pool infrastructure distributes jobs, receives results, and records each participant’s contribution. As a result, the combined computing power of the pool has a much greater chance of finding a block than a small individual miner operating alone.</p>

                <h3>How a Mining Pool Works</h3>

                <ol>
                    <li>The miner configures its equipment and connects it to a pool server.</li>
                    <li>The pool identifies the connected device or <span class="term" data-term="mining-pools/pool-worker">worker</span> and assigns it a job.</li>
                    <li>The miner performs computations and searches for results that meet the pool’s configured <span class="term" data-term="mining-pools/share-difficulty">share difficulty</span>.</li>
                    <li>Suitable results are sent back to the pool as <span class="term" data-term="mining-pools/share">shares</span>.</li>
                    <li>The pool verifies the submitted results and records valid shares in the participant’s statistics.</li>
                    <li>If one participant finds a valid block, the pool processes the block according to the rules of the blockchain network.</li>
                    <li>The resulting reward is distributed among participants according to the selected <span class="term" data-term="mining-pools/payout-scheme">payout scheme</span>.</li>
                </ol>

                <h3>Why Shares Are Used</h3>

                <p>Full blocks are found relatively infrequently compared with the number of computational attempts performed by miners. The pool therefore needs an intermediate metric that allows it to measure each participant’s work regularly. This metric is the share.</p>

                <p>The pool assigns a separate share difficulty that is normally much lower than the network difficulty. This allows even relatively small miners to submit results regularly. The frequency and difficulty of accepted shares provide the pool with a statistical estimate of the work actually performed by each participant.</p>

                <p>A share is normally not a complete block. However, a sufficiently difficult share can also satisfy the blockchain’s network-level requirement. In that case, the result can represent a valid block candidate.</p>

                <h3>What the Pool Tracks</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Practical Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hashrate</td>
                            <td>Shows the computing power of connected equipment.</td>
                        </tr>
                        <tr>
                            <td>Shares</td>
                            <td>Used to confirm and measure completed work.</td>
                        </tr>
                        <tr>
                            <td>Rejected shares</td>
                            <td>Shows results that were not credited by the pool.</td>
                        </tr>
                        <tr>
                            <td>Worker status</td>
                            <td>Allows individual devices to be monitored for connection and activity.</td>
                        </tr>
                        <tr>
                            <td>Payout balance</td>
                            <td>Shows the participant’s accumulated reward.</td>
                        </tr>
                    </tbody>
                </table>

                <h3>How Rewards Are Distributed</h3>

                <p>When a block is found, the pool receives the reward defined by the network protocol. It can include the <span class="term" data-term="mining/block-reward">block reward</span>, consisting of the subsidy and transaction fees.</p>

                <p>The participant normally does not receive the entire block reward individually. A <span class="term" data-term="mining-pools/pool-fee">pool fee</span> may first be deducted, after which the remaining amount is distributed among participants according to the selected payout scheme.</p>

                <p>For example, under PPS, a payout can be calculated for each accepted share, while PPLNS uses a defined set of recent shares. Therefore, the same hashrate can produce different payment patterns depending on the payout model.</p>

                <h3>Main Mining Pool Parameters</h3>

                <ul>
                    <li><strong>Pool fee</strong> — the fee retained by the pool.</li>
                    <li><strong>Payout threshold</strong> — the minimum balance required for a payout.</li>
                    <li><strong>Payout scheme</strong> — the rules used to calculate rewards.</li>
                    <li><strong>Share difficulty</strong> — the difficulty used for intermediate results.</li>
                    <li><strong>Stratum</strong> — the communication protocol used for jobs and results.</li>
                    <li><strong>VarDiff</strong> — a mechanism for automatically changing share difficulty.</li>
                </ul>

                <h3>What Matters When Evaluating a Pool</h3>

                <p>The fee is only one parameter. Server stability, connection latency, the rate of rejected and stale shares, payout rules, minimum payout threshold, and supported protocols can also affect the practical result of mining.</p>

                <p>If communication between the miner and pool is unstable, some computational work can become stale before it reaches the server. Therefore, pool infrastructure and network quality can affect the effective performance of mining equipment.</p>

                <p>A mining pool is the infrastructure layer connecting individual miners with collaborative block production. Understanding it requires distinguishing <span class="term" data-term="mining-pools/pool-mining">Pool Mining</span>, <span class="term" data-term="mining-pools/share">Share</span>, <span class="term" data-term="mining-pools/payout-scheme">Payout Scheme</span>, and the <span class="term" data-term="mining-pools/stratum">Stratum</span> protocol.</p>'
            ],

            'pool-mining' => [
                'title' => 'What Is Pool Mining | TM Wiki',
                'description' => 'Pool Mining is collaborative mining where participants combine computing power and receive rewards for their contribution.',
                'name' => 'Pool Mining',
                'caption' => 'A collaborative mining model based on combining the computing resources of multiple participants.',
                'definition' => '<p><strong>Pool Mining</strong> is a mining model in which multiple independent participants combine their computing resources through a shared <span class="term" data-term="mining-pools/mining-pool">Mining Pool</span>. Each participant continues performing computations on their own hardware, while the resulting work is submitted to shared pool infrastructure.</p>

                <p>The main reason for using Pool Mining is the probabilistic nature of block discovery. If an individual miner controls only a small share of the network’s computing power, the probability that their equipment finds the next block can be low. Combining many miners increases the frequency with which the group as a whole can find blocks.</p>

                <h3>Pool Mining Mechanics</h3>

                <p>The pool creates jobs and distributes them to connected devices. Participant contribution is tracked using <span class="term" data-term="mining-pools/share">shares</span> — computational results that meet the difficulty configured by the pool. The miner submits these results to the server, and the pool verifies them and associates them with a specific worker.</p>

                <p>When the pool finds a block, the resulting reward is distributed among participants. The distribution method is defined by the <span class="term" data-term="mining-pools/payout-scheme">payout scheme</span>. Some schemes primarily use the number and difficulty of accepted shares, while others use a defined historical or quantitative window.</p>

                <h3>Pool Mining vs. Solo Mining</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Characteristic</th>
                            <th>Pool Mining</th>
                            <th>Solo Mining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Combined computing power</td>
                            <td>Yes</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td>Job source</td>
                            <td>Pool</td>
                            <td>Network or own infrastructure</td>
                        </tr>
                        <tr>
                            <td>Share tracking</td>
                            <td>Yes</td>
                            <td>Normally not required in the pool sense</td>
                        </tr>
                        <tr>
                            <td>Reward distribution</td>
                            <td>Among participants according to pool rules</td>
                            <td>Goes to the participant that finds the block</td>
                        </tr>
                        <tr>
                            <td>Pool fee</td>
                            <td>May apply</td>
                            <td>None</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Economic Characteristics</h3>

                <p>Pool Mining does not increase the computing power of an individual device. It changes how that power is organized and how the resulting rewards are distributed. Participant economics therefore depend not only on hashrate but also on pool fees, payout schemes, network difficulty, block rewards, and electricity costs.</p>

                <p>For a participant with a small hashrate, payout regularity can also matter. Even when expected income is determined by the same network parameters, the actual timing of payments depends on the selected payout model and the frequency with which the pool finds blocks.</p>

                <h3>Related Concepts</h3>

                <p>Pool Mining is directly related to <span class="term" data-term="mining-pools/mining-pool">Mining Pool</span>, <span class="term" data-term="mining-pools/share">Share</span>, <span class="term" data-term="mining-pools/pool-fee">Pool Fee</span>, <span class="term" data-term="mining-pools/payout-scheme">Payout Scheme</span>, and the <span class="term" data-term="mining-pools/stratum">Stratum</span> protocol.</p>'
            ],

            'pool-worker' => [
                'title' => 'What Is a Pool Worker | TM Wiki',
                'description' => 'A Pool Worker identifies a device or group of devices so a mining pool can track its work and display separate statistics.',
                'name' => 'Pool Worker',
                'caption' => 'A logical mining unit used by a pool to track computational work separately.',
                'definition' => '<p><strong>Pool Worker</strong> is a logical identifier used by a mining pool to separate the computational work of one device or group of devices from other connected participants. Workers are primarily used for statistics, monitoring, and troubleshooting.</p>

                <p>A physical miner and a worker are not necessarily the same thing. For example, one ASIC can operate as one worker, while multiple processes or devices may be represented differently depending on the mining software and configuration.</p>

                <h3>Data Associated with a Worker</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Purpose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hashrate</td>
                            <td>Monitoring actual computing performance.</td>
                        </tr>
                        <tr>
                            <td>Shares</td>
                            <td>Tracking submitted computational work.</td>
                        </tr>
                        <tr>
                            <td>Rejected shares</td>
                            <td>Monitoring results rejected by the pool.</td>
                        </tr>
                        <tr>
                            <td>Connection status</td>
                            <td>Determining whether the device is connected and active.</td>
                        </tr>
                        <tr>
                            <td>Worker name</td>
                            <td>Identifying a specific device or logical group.</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Why Separate Workers Are Useful</h3>

                <p>When several miners are connected to the same pool, separate workers make it easier to identify which device is operating normally, which has reduced its hashrate, and which has stopped submitting shares.</p>

                <p>For example, with ten ASIC miners, a single shared identifier would make troubleshooting much harder. If every ASIC has a separate worker identifier, the operator can compare their hashrates, share counts, rejected results, and last activity.</p>

                <h3>Workers and Payouts</h3>

                <p>A worker is normally an accounting and monitoring unit rather than an independent payment recipient. A pool can aggregate the work of multiple workers belonging to the same account and calculate a combined balance. The exact model depends on the pool infrastructure.</p>

                <p>Pool Worker can therefore be viewed as the logical layer between physical mining hardware and the pool’s statistical system.</p>'
            ],

            'share' => [
                'title' => 'What Is a Share in Mining | TM Wiki',
                'description' => 'A share is a computational result submitted to a pool to prove completed work and calculate the miner’s contribution.',
                'name' => 'Share',
                'caption' => 'An intermediate computational result used by a pool to measure a miner’s work.',
                'definition' => '<p><strong>Share</strong> is a computational result produced by a miner that meets the difficulty configured by the pool and is submitted to the server for verification. Shares provide a measurable way for a mining pool to track the work performed by each participant.</p>

                <p>During mining, hardware performs a very large number of hash operations. Most results have no significance for the blockchain network. If a pool required miners to submit only results meeting the full network difficulty, a small miner could go for a very long time without submitting anything. The pool would therefore have no practical way to continuously measure whether the device was working and how much work it was performing.</p>

                <h3>How a Share Is Created</h3>

                <ol>
                    <li>The pool creates or receives a current mining job.</li>
                    <li>The job is sent to the miner through the communication protocol.</li>
                    <li>The miner performs computations.</li>
                    <li>A result meets the configured share difficulty.</li>
                    <li>The miner submits the result to the pool.</li>
                    <li>The pool verifies and either accepts or rejects it.</li>
                </ol>

                <h3>Share vs. Block</h3>

                <p>A share should not be confused with a block. They operate at different difficulty levels.</p>

                <table>
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Share</th>
                            <th>Block</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Difficulty</td>
                            <td>Configured by the pool for work accounting</td>
                            <td>Defined by the network</td>
                        </tr>
                        <tr>
                            <td>Frequency</td>
                            <td>Designed to be frequent enough for statistical tracking</td>
                            <td>Much lower</td>
                        </tr>
                        <tr>
                            <td>Economic role</td>
                            <td>Used to calculate the participant’s contribution</td>
                            <td>Creates eligibility for the block reward</td>
                        </tr>
                    </tbody>
                </table>

                <p>Occasionally, a share also satisfies the network-level requirement. In that case, it can represent a block discovery. Most shares, however, serve only as evidence of completed work for the pool’s internal accounting.</p>

                <h3>Types of Shares</h3>

                <p>Depending on the result and the time at which it is submitted, a share can be accepted, rejected, or considered stale. Pool monitoring therefore commonly distinguishes <span class="term" data-term="mining-pools/valid-share">Valid Share</span>, <span class="term" data-term="mining-pools/invalid-share">Invalid Share</span>, and <span class="term" data-term="mining-pools/stale-share">Stale Share</span>.</p>'
            ],

            'valid-share' => [
                'title' => 'What Is a Valid Share | TM Wiki',
                'description' => 'A Valid Share is a correct mining result that meets pool difficulty and is accepted for tracking computational contribution.',
                'name' => 'Valid Share',
                'caption' => 'A correct share accepted by the pool and credited as completed work.',
                'definition' => '<p><strong>Valid Share</strong> is a correct computational result that satisfies the configured <span class="term" data-term="mining-pools/share-difficulty">share difficulty</span> and the other requirements of the current mining job. After verification, the result is accepted by the pool and can be used when calculating the participant’s reward.</p>

                <p>Valid shares are one of the primary mechanisms used to measure a participant’s contribution in Pool Mining. Since full blocks are found relatively rarely, a pool needs a more frequent way to verify that connected equipment is actually performing work.</p>

                <h3>What the Pool Verifies</h3>

                <ul>
                    <li>that the result belongs to the current job;</li>
                    <li>that the computed value is correct;</li>
                    <li>that the result meets the configured difficulty;</li>
                    <li>that the result is not a duplicate;</li>
                    <li>that the underlying job is still valid.</li>
                </ul>

                <h3>Valid Shares and Payouts</h3>

                <p>Accepted shares can be used differently by different payout systems. Under <span class="term" data-term="mining-pools/pay-per-share">PPS</span>, for example, each accepted share has a calculated value. Under <span class="term" data-term="mining-pools/pplns">PPLNS</span>, the participant’s contribution is measured within a defined window of recent shares.</p>

                <p>Therefore, a valid share does not have one universal fixed monetary value. Its economic value depends on share difficulty, payout scheme, network conditions, and the specific rules of the pool.</p>'
            ],

            'stale-share' => [
                'title' => 'What Is a Stale Share | TM Wiki',
                'description' => 'A Stale Share is an outdated mining result submitted after a job changed and normally not credited by the pool.',
                'name' => 'Stale Share',
                'caption' => 'A share associated with a mining job that is no longer current.',
                'definition' => '<p><strong>Stale Share</strong> is a computational result produced from a mining job that has already become outdated. The result itself can be mathematically correct, but by the time it reaches the pool, the associated work is no longer relevant.</p>

                <p>The most common situation occurs when a new block is found by the network. Once a new block appears, the previous job may no longer be valid for continued mining. The pool sends new work to miners, but some devices can continue processing the previous job for a short period or submit results with a delay.</p>

                <h3>Common Causes of Stale Shares</h3>

                <ul>
                    <li>high latency between the miner and pool server;</li>
                    <li>unstable internet connectivity;</li>
                    <li>delayed delivery of a new job;</li>
                    <li>network or server overload;</li>
                    <li>slow command processing by the hardware;</li>
                    <li>software errors or delays.</li>
                </ul>

                <h3>How the Stale Rate Is Measured</h3>

                <p>A pool can display the number or percentage of stale shares relative to all submitted results. A small number of stale shares can occur even during normal operation because of delays in propagating new jobs.</p>

                <p>A persistently high stale-share rate can indicate that a significant amount of computational work is being performed on jobs that are no longer current. The metric is therefore useful for diagnosing network infrastructure and miner configuration.</p>

                <p>A Stale Share differs from an <span class="term" data-term="mining-pools/invalid-share">Invalid Share</span>: a stale result can be mathematically correct but outdated, while an invalid share fails the correctness requirements of the result itself.</p>'
            ],

            'invalid-share' => [
                'title' => 'What Is an Invalid Share | TM Wiki',
                'description' => 'An Invalid Share is a computational result that fails the requirements of the job or the mining pool’s validation.',
                'name' => 'Invalid Share',
                'caption' => 'An incorrect share that the pool does not accept as completed work.',
                'definition' => '<p><strong>Invalid Share</strong> is a computational result that fails the pool’s validation. Unlike a stale share, the problem is not simply that the result arrived too late: the result itself does not meet the requirements of the current job or the pool’s validation rules.</p>

                <h3>Common Causes</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Cause</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Unstable chip</td>
                            <td>Hardware produces incorrect results because of unstable operation.</td>
                        </tr>
                        <tr>
                            <td>Overclocking</td>
                            <td>Aggressive settings can cause computational errors.</td>
                        </tr>
                        <tr>
                            <td>Memory problems</td>
                            <td>Memory errors can alter computational results.</td>
                        </tr>
                        <tr>
                            <td>Configuration</td>
                            <td>Incorrect software parameters can cause invalid results.</td>
                        </tr>
                        <tr>
                            <td>Software error</td>
                            <td>Client or firmware failures can produce incorrect data.</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Why Invalid Shares Matter</h3>

                <p>A persistently elevated invalid-share rate can indicate that the effective performance of the equipment is below its expected level. A high error rate can also point to problems with stability, temperature, overclocking, power, or software.</p>

                <p>During troubleshooting, invalid shares should be distinguished from <span class="term" data-term="mining-pools/stale-share">stale shares</span> and other forms of <span class="term" data-term="mining-pools/rejected-share">rejected shares</span>, because their causes and corrective actions can differ.</p>'
            ],

            'rejected-share' => [
                'title' => 'What Is a Rejected Share | TM Wiki',
                'description' => 'A Rejected Share is a result submitted by a miner but refused by the pool and excluded from credited work.',
                'name' => 'Rejected Share',
                'caption' => 'A share that the pool does not accept for further accounting.',
                'definition' => '<p><strong>Rejected Share</strong> is a general term for a result submitted by a miner but not accepted by the pool. Depending on the system, the reason can be an outdated job, computational error, duplicate result, protocol error, or another violation of the pool’s validation requirements.</p>

                <p>Rejected share therefore describes the processing outcome rather than one specific cause.</p>

                <h3>Common Rejection Reasons</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Problem Type</th>
                            <th>What Happened</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Stale Share</td>
                            <td>The result belongs to an outdated job.</td>
                        </tr>
                        <tr>
                            <td>Invalid Share</td>
                            <td>The result fails correctness requirements.</td>
                        </tr>
                        <tr>
                            <td>Duplicate</td>
                            <td>The pool has already received the same result.</td>
                        </tr>
                        <tr>
                            <td>Protocol error</td>
                            <td>The result does not match the expected format or connection state.</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Rejected Shares and Mining Efficiency</h3>

                <p>A small percentage of rejected results can occur during normal operation because of network latency and job-processing characteristics. A persistently high rejection rate, however, requires investigation.</p>

                <p>The cause of rejection should be identified before troubleshooting. If stale shares dominate, attention should be given to network latency and connectivity. If invalid shares dominate, hardware stability, configuration, temperature, and software should be checked.</p>'
            ],

            'share-difficulty' => [
                'title' => 'What Is Share Difficulty | TM Wiki',
                'description' => 'Share Difficulty is the difficulty assigned by a pool to obtain intermediate mining results at a suitable frequency.',
                'name' => 'Share Difficulty',
                'caption' => 'The difficulty level used by a pool to regularly track a miner’s computational work.',
                'definition' => '<p><strong>Share Difficulty</strong> is the difficulty level assigned by a mining pool to intermediate mining results. A computational result that meets this difficulty qualifies as a share and can be used to measure the participant’s contribution.</p>

                <p>Share difficulty is normally much lower than blockchain network difficulty. This allows a pool to receive results from miners much more frequently than the network produces complete blocks.</p>

                <h3>Why Separate Difficulty Is Necessary</h3>

                <p>Consider a blockchain with very high network difficulty. If every miner were required to submit only results capable of satisfying the network condition, a low-hashrate device might go a very long time without producing a reportable result. The pool would therefore have little practical information about whether the device was working or how much work it was performing.</p>

                <p>Share difficulty solves this problem. The pool sets a more accessible threshold and receives regular intermediate results that statistically represent the miner’s work.</p>

                <h3>Relationship with Hashrate</h3>

                <p>All else being equal, a more powerful miner finds shares more frequently at the same difficulty. A pool can therefore increase share difficulty for high-hashrate workers and decrease it for lower-hashrate workers.</p>

                <p>This automatic adaptation is performed by <span class="term" data-term="mining-pools/vardiff">VarDiff</span>.</p>

                <h3>Share Difficulty vs. Network Difficulty</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Share Difficulty</th>
                            <th>Network Difficulty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Set by</td>
                            <td>Mining pool</td>
                            <td>Blockchain network rules</td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td>Track miner work</td>
                            <td>Define the block-finding condition</td>
                        </tr>
                        <tr>
                            <td>Affects consensus</td>
                            <td>No</td>
                            <td>Yes</td>
                        </tr>
                    </tbody>
                </table>

                <p>Changing share difficulty does not mean that the cryptocurrency has become harder or easier to mine. It changes only the frequency of intermediate results submitted by miners to the pool.</p>'
            ],

            'pool-fee' => [
                'title' => 'What Is a Pool Fee | TM Wiki',
                'description' => 'A Pool Fee is a mining-pool charge deducted from participant income for infrastructure and pool services.',
                'name' => 'Pool Fee',
                'caption' => 'A fee deducted by the pool from a miner’s calculated reward.',
                'definition' => '<p><strong>Pool Fee</strong> is a charge retained by a mining pool for providing server infrastructure, distributing jobs, processing shares, calculating rewards, and processing payouts.</p>

                <p>The fee is commonly expressed as a percentage of the amount that would otherwise be distributed to participants. For example, with a hypothetical 1% fee, part of the calculated reward goes to the pool operator, while the remaining amount is distributed according to the selected payout scheme.</p>

                <h3>What the Fee Pays For</h3>

                <ul>
                    <li>server and network infrastructure;</li>
                    <li>distribution of mining jobs;</li>
                    <li>receipt and validation of shares;</li>
                    <li>statistics and monitoring;</li>
                    <li>participant balance accounting;</li>
                    <li>payout processing.</li>
                </ul>

                <h3>Pool Fees and Actual Income</h3>

                <p>The Pool Fee directly reduces the amount remaining for the miner after settlement with the pool. Therefore, when comparing pools, the fee should be considered together with the payout scheme and other conditions.</p>

                <p>For example, a lower fee by itself does not guarantee a higher actual payout under every circumstance. The result also depends on how shares are valued, how rewards are distributed, how frequently blocks are found, and what payout conditions apply.</p>

                <h3>Pool Fee and Profitability</h3>

                <p>When calculating <span class="term" data-term="mining-economics/mining-profitability">mining profitability</span>, the pool fee should be treated as an expense that reduces mining income. With other conditions equal, a higher total fee leaves less net revenue for the miner.</p>

                <p>The exact Pool Fee is determined by the pool operator and can differ between cryptocurrencies, payout schemes, and mining modes.</p>'
            ],

            'payout-threshold' => [
                'title' => 'What Is a Payout Threshold | TM Wiki',
                'description' => 'A Payout Threshold is the minimum balance required before a pool sends accumulated mining rewards to a participant.',
                'name' => 'Payout Threshold',
                'caption' => 'The minimum accumulated balance required before a payout is processed.',
                'definition' => '<p><strong>Payout Threshold</strong> is the minimum amount a participant must accumulate in a mining-pool balance before a payout can be processed. Until the balance reaches the configured threshold, the reward normally remains on the pool account.</p>

                <h3>Why Pools Use a Payout Threshold</h3>

                <p>If every small amount were sent as a separate blockchain transaction, the pool would have to process a large number of small payouts. A threshold allows the system to accumulate rewards and reduce the number of outgoing transactions.</p>

                <p>For example, if the threshold is set to 0.01 coins, a balance of 0.006 coins would normally remain on the pool account. After additional rewards bring the balance to 0.01 coins, the pool can initiate a payout according to its rules.</p>

                <h3>What Determines the Actual Payout</h3>

                <ul>
                    <li>the accumulated balance;</li>
                    <li>the configured payout threshold;</li>
                    <li>automatic payout rules;</li>
                    <li>transaction fees and payout conditions;</li>
                    <li>network and pool availability.</li>
                </ul>

                <p>The payout threshold does not determine mining profitability. It primarily affects when credited mining income is converted into an external transfer.</p>

                <p>For cash-flow analysis, it is therefore useful to distinguish between <strong>accrued mining income</strong>, <strong>the pool balance</strong>, and <strong>funds actually received externally</strong>.</p>'
            ],

            'payout-scheme' => [
                'title' => 'What Is a Payout Scheme | TM Wiki',
                'description' => 'A Payout Scheme defines how a mining pool calculates each participant’s share of income from mined blocks.',
                'name' => 'Payout Scheme',
                'caption' => 'Rules for calculating and distributing rewards among mining-pool participants.',
                'definition' => '<p><strong>Payout Scheme</strong> is the model used by a mining pool to calculate and distribute rewards among participants. It defines which work results are counted, which period they belong to, and how each miner’s share of the distributable income is calculated.</p>

                <p>Different schemes can use the same underlying computational data while distributing the resulting cash flow differently over time. The payout model is therefore an important parameter when comparing mining conditions.</p>

                <h3>Common Models</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Scheme</th>
                            <th>Principle</th>
                            <th>What Is Counted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PPS</td>
                            <td>Payment for each accepted share</td>
                            <td>Accepted shares and calculated work value</td>
                        </tr>
                        <tr>
                            <td>PPLNS</td>
                            <td>Reward distribution based on recent shares</td>
                            <td>Shares within a defined window</td>
                        </tr>
                        <tr>
                            <td>FPPLNS</td>
                            <td>PPLNS variant with a fixed rule</td>
                            <td>Shares within a fixed calculation window</td>
                        </tr>
                        <tr>
                            <td>Solo Pool</td>
                            <td>Reward when the participant finds a block</td>
                            <td>Actual block discovery</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Why the Payout Scheme Matters</h3>

                <p>The same miner can receive a different payment pattern depending on the payout scheme. Under PPS, payments are directly connected to accepted shares and can therefore be more regular. Under PPLNS, the result is more closely connected to the pool’s actual block discoveries and the participant’s contribution within the relevant window.</p>

                <p>The payout scheme does not change the underlying network block reward or create additional computing power. It determines how the economic result is allocated between the pool and its participants.</p>

                <h3>What to Check in Pool Rules</h3>

                <ul>
                    <li>the exact payout formula;</li>
                    <li>which shares are counted;</li>
                    <li>the size and duration of the calculation window;</li>
                    <li>the pool fee;</li>
                    <li>payout processing rules;</li>
                    <li>the minimum payout threshold;</li>
                    <li>rules applied when a block is found or a job changes.</li>
                </ul>'
            ],

            'pay-per-share' => [
                'title' => 'What Is Pay Per Share | TM Wiki',
                'description' => 'Pay Per Share is a payout scheme where miners receive a calculated reward for each share accepted by the pool.',
                'name' => 'Pay Per Share',
                'caption' => 'A payout scheme where rewards are calculated for each accepted share.',
                'definition' => '<p><strong>Pay Per Share (PPS)</strong> is a mining-pool payout scheme in which a participant receives a calculated reward for every accepted share. The payment is determined using a formula based on the expected value of the computational work and relevant network parameters.</p>

                <h3>How PPS Works</h3>

                <p>The miner performs computations and submits shares to the pool. Once a share is accepted, the system credits the participant with the corresponding amount. The payout for a particular share does not necessarily depend on whether the pool has just found a block at that moment.</p>

                <p>As a result, the pool operator assumes a significant portion of the variation between the actual timing of block discoveries and the statistically expected block frequency. The participant is credited according to accepted work while the pool manages the difference between credited amounts and actual block rewards received by the pool.</p>

                <h3>What Can Be Included in the Calculation</h3>

                <ul>
                    <li>network difficulty;</li>
                    <li>share difficulty;</li>
                    <li>block reward;</li>
                    <li>expected block frequency;</li>
                    <li>pool fee;</li>
                    <li>the specific PPS implementation.</li>
                </ul>

                <h3>PPS vs. PPLNS</h3>

                <p>The main difference from <span class="term" data-term="mining-pools/pplns">PPLNS</span> is the timing and basis of reward calculation. Under PPS, the accepted share receives a calculated value directly according to the PPS model. Under PPLNS, the reward depends on the participant’s contribution within a defined set of recent shares associated with a block found by the pool.</p>

                <p>For this reason, comparing pools based only on their percentage fee is insufficient. The payout formula and the conditions used to calculate the value of work should also be considered.</p>'
            ],

            'pplns' => [
                'title' => 'What Is PPLNS in Mining | TM Wiki',
                'description' => 'PPLNS is a payout scheme that uses the last N shares when distributing the reward from a block found by the pool.',
                'name' => 'PPLNS',
                'caption' => 'A payout scheme based on a miner’s contribution within a defined window of recent shares.',
                'definition' => '<p><strong>PPLNS (Pay Per Last N Shares)</strong> is a mining-pool payout scheme in which the last <em>N</em> shares are considered when distributing a block reward. The exact definition of the window and the rules used to apply it depend on the pool implementation.</p>

                <p>Unlike a scheme where every accepted share receives a predetermined calculated value independently of when a block is found, PPLNS links the payout to a specific historical set of participant work.</p>

                <h3>How PPLNS Works</h3>

                <ol>
                    <li>The pool continuously receives and records accepted shares.</li>
                    <li>Participants contribute work at different hashrates.</li>
                    <li>The pool finds a block.</li>
                    <li>The applicable window of the last N shares is determined.</li>
                    <li>Each participant’s share of the total contribution within that window is calculated.</li>
                    <li>The distributable reward is divided according to the credited contribution.</li>
                </ol>

                <h3>Why the Window Size Matters</h3>

                <p>With a smaller window, the result is more sensitive to recent activity and the timing of a miner’s participation. With a larger window, short-term changes in participation are distributed over a broader set of work.</p>

                <p>Therefore, two pools that both use PPLNS can produce different payout patterns if they use different values of N or different rules for defining the calculation window.</p>

                <h3>Example</h3>

                <p>Assume a pool uses a window of 1,000,000 shares. If a particular participant’s equipment contributes shares representing 2% of the total credited work within that window, the participant’s share of the distributable reward would be calculated from that 2%, subject to the pool’s rules and fee.</p>

                <p>If a miner starts working immediately before a block is found, a significant portion of their work may not be included in the relevant historical window.</p>

                <h3>PPLNS and Payout Regularity</h3>

                <p>PPLNS does not guarantee equal payouts at equal time intervals. Actual income depends on the blocks found by the pool, participant contribution, and the size of the calculation window. As a result, payouts can fluctuate even when hashrate remains relatively stable.</p>'
            ],

            'fpplns' => [
                'title' => 'What Is FPPLNS in Mining | TM Wiki',
                'description' => 'FPPLNS is a PPLNS variant with a fixed rule for calculating participant contribution when distributing block income.',
                'name' => 'FPPLNS',
                'caption' => 'A PPLNS variant using a fixed calculation window or rule for credited shares.',
                'definition' => '<p><strong>FPPLNS</strong> is a payout scheme based on the <span class="term" data-term="mining-pools/pplns">PPLNS</span> principle but using a fixed rule to determine which shares are included in the reward calculation.</p>

                <p>The name is commonly expanded as Fixed Pay Per Last N Shares. However, the exact implementation can vary between mining pools. When comparing payout systems in practice, the rules of the specific pool should therefore be used rather than relying on the scheme name alone.</p>

                <h3>How It Works</h3>

                <p>The pool receives shares from all connected participants and maintains a history of their work. When a block is found, the pool applies the predefined rule that determines which shares are included in the calculation. Each participant’s contribution is then calculated and the corresponding portion of the reward is distributed.</p>

                <h3>FPPLNS vs. the General PPLNS Concept</h3>

                <p>PPLNS describes the general principle of paying according to the last N shares. FPPLNS emphasizes the use of a fixed calculation rule or window. In practice, terminology can differ between pools, so the exact formula should always be checked in the documentation of the specific service.</p>

                <table>
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Basis</td><td>PPLNS</td></tr>
                        <tr><td>Work accounting</td><td>Shares within a defined calculation window</td></tr>
                        <tr><td>Distribution</td><td>Proportional to credited contribution</td></tr>
                        <tr><td>Exact formula</td><td>Depends on the specific pool</td></tr>
                    </tbody>
                </table>'
            ],

            'solo-pool' => [
                'title' => 'What Is a Solo Pool | TM Wiki',
                'description' => 'A Solo Pool provides pool infrastructure while keeping the block reward with the participant whose equipment finds the block.',
                'name' => 'Solo Pool',
                'caption' => 'A pool mode where the reward for a found block is attributed to the participant that finds it.',
                'definition' => '<p><strong>Solo Pool</strong> is a mining model that combines mining-pool infrastructure with independent receipt of a block reward. The miner uses the pool’s servers to receive jobs and submit results, but does not participate in the normal distribution of every block reward among all pool participants.</p>

                <p>If the participant’s equipment finds a block that satisfies the network requirements, the block reward is attributed to that participant according to the pool’s rules. The operator may deduct an applicable pool fee.</p>

                <h3>Why Solo Pools Are Used</h3>

                <p>Operating completely independently requires additional infrastructure, including a node, job processing, and direct interaction with the blockchain network. A Solo Pool can provide part of that infrastructure while preserving the probabilistic model of independently finding a block.</p>

                <h3>Solo Pool vs. Standard Mining Pool</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Characteristic</th>
                            <th>Solo Pool</th>
                            <th>Standard Mining Pool</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Who receives the reward</td>
                            <td>The participant whose equipment finds the block</td>
                            <td>Participants according to the payout scheme</td>
                        </tr>
                        <tr>
                            <td>Pool infrastructure</td>
                            <td>Yes</td>
                            <td>Yes</td>
                        </tr>
                        <tr>
                            <td>Share distribution between participants</td>
                            <td>Not used for normal reward distribution</td>
                            <td>Used</td>
                        </tr>
                        <tr>
                            <td>Payout variability</td>
                            <td>High and dependent on block discovery</td>
                            <td>Depends on the selected scheme</td>
                        </tr>
                    </tbody>
                </table>

                <p>The main characteristic of a Solo Pool is that it preserves the full probabilistic nature of block discovery. If the participant controls only a small share of the network’s computing power, the interval between successful block discoveries can be very long.</p>

                <p>Solo Pool should therefore be distinguished from ordinary <span class="term" data-term="mining-pools/pool-mining">Pool Mining</span>: both use pool infrastructure, but their economic reward-distribution mechanisms are different.</p>'
            ],

            'stratum' => [
                'title' => 'What Is Stratum in Mining | TM Wiki',
                'description' => 'Stratum is a protocol for exchanging mining jobs and computational results between miners and pool servers.',
                'name' => 'Stratum',
                'caption' => 'A communication protocol used by miners to interact with mining-pool infrastructure.',
                'definition' => '<p><strong>Stratum</strong> is a communication protocol family used between mining hardware or a mining client and pool infrastructure. It defines how jobs, computational results, and service information required for collaborative mining are exchanged.</p>

                <p>In a typical mining architecture, a miner does not need to interact with the blockchain network for every individual computational attempt. Instead, it receives work through a pool. Stratum provides the communication layer through which the pool specifies what should be calculated and the miner reports discovered shares.</p>

                <h3>Main Stratum Functions</h3>

                <ul>
                    <li>establishing and maintaining connections;</li>
                    <li>worker authentication or identification;</li>
                    <li>transmitting job parameters;</li>
                    <li>notifying miners when new work becomes available;</li>
                    <li>submitting discovered shares;</li>
                    <li>handling service messages;</li>
                    <li>maintaining connection state.</li>
                </ul>

                <h3>Stratum in Pool Architecture</h3>

                <p>A simplified architecture can be represented as:</p>

                <p><strong>Miner → Stratum → Pool Server → Pool Infrastructure → Blockchain Network.</strong></p>

                <p>Real-world architectures can be more complex, and the exact implementation depends on the cryptocurrency, mining software, and protocol version.</p>

                <h3>Why the Protocol Matters</h3>

                <p>Mining requires a continuous exchange of new jobs and computational results. If communication is unstable, equipment can continue working on an outdated job, increasing the number of <span class="term" data-term="mining-pools/stale-share">stale shares</span>. Connection latency, reliability, and correct message handling therefore have direct practical significance.</p>

                <p>The most widely discussed versions are <span class="term" data-term="mining-pools/stratum-v1">Stratum V1</span> and <span class="term" data-term="mining-pools/stratum-v2">Stratum V2</span>.</p>'
            ],

            'stratum-v1' => [
                'title' => 'What Is Stratum V1 | TM Wiki',
                'description' => 'Stratum V1 is a widely used protocol for communication between miners and pools to exchange jobs and computational results.',
                'name' => 'Stratum V1',
                'caption' => 'The first widely adopted version of the Stratum protocol for pool mining.',
                'definition' => '<p><strong>Stratum V1</strong> is a communication protocol between miners and mining-pool servers that became widely adopted in cryptocurrency mining infrastructure. Its primary purpose is to provide continuous communication for distributing jobs and receiving computational results from connected devices.</p>

                <h3>How Stratum V1 Works</h3>

                <ol>
                    <li>The miner establishes a connection to the pool server.</li>
                    <li>The device or client provides information identifying the worker.</li>
                    <li>The pool sends the job parameters.</li>
                    <li>The miner performs computations.</li>
                    <li>When a suitable result is found, the miner submits a share.</li>
                    <li>The pool verifies the result and returns acceptance or rejection information.</li>
                    <li>When the job changes, the miner receives new parameters.</li>
                </ol>

                <h3>Why Stratum V1 Became Widely Used</h3>

                <p>The protocol made it practical to coordinate large numbers of miners through centralized pool servers. Instead of requiring every device to continuously process and exchange large amounts of blockchain information, the pool could distribute compact jobs and receive computational results.</p>

                <p>This is particularly useful for specialized mining hardware that performs computations at very high speed and can be sensitive to communication delays.</p>

                <h3>Limitations</h3>

                <p>Stratum V1 was developed around an architecture in which a significant portion of mining coordination is controlled by the pool. Newer approaches place more emphasis on communication security, authentication, flexible role distribution, and reducing the dependence of individual components on centralized control.</p>

                <p>These are among the considerations that led to the development of <span class="term" data-term="mining-pools/stratum-v2">Stratum V2</span>.</p>

                <p>Specific behavior can differ depending on the implementation, mining client, and blockchain network.</p>'
            ],

            'stratum-v2' => [
                'title' => 'What Is Stratum V2 | TM Wiki',
                'description' => 'Stratum V2 is a mining protocol with a modern communication architecture for miners and pool infrastructure.',
                'name' => 'Stratum V2',
                'caption' => 'A newer generation of Stratum designed for more efficient and secure mining communication.',
                'definition' => '<p><strong>Stratum V2</strong> is a mining communication protocol and architecture developed as an evolution of the <span class="term" data-term="mining-pools/stratum-v1">Stratum V1</span> approach. Its design aims to make communication between miners, pools, and other infrastructure components more efficient, structured, and secure.</p>

                <p>Stratum V2 treats communication not simply as the transmission of individual jobs but as a set of structured messages and roles between participants. This makes it possible to separate functions that were more commonly concentrated on one side of the system in older architectures.</p>

                <h3>Key Features</h3>

                <ul>
                    <li>a formally structured message and procedure system;</li>
                    <li>protected communication between components;</li>
                    <li>authentication and connection management;</li>
                    <li>efficient job transmission;</li>
                    <li>more flexible role separation between miners and pools;</li>
                    <li>support for more flexible transaction-selection architectures in applicable implementations.</li>
                </ul>

                <h3>Stratum V2 and Transaction Selection</h3>

                <p>One architectural feature is the ability to change how control over work construction is distributed. In certain configurations, miners can have more influence over the selection of transactions included in a block template instead of assigning that function entirely to the pool.</p>

                <p>The exact behavior depends on the protocol implementation, pool, mining software, and supported features.</p>

                <h3>Stratum V1 vs. Stratum V2</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Characteristic</th>
                            <th>Stratum V1</th>
                            <th>Stratum V2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Architecture</td>
                            <td>Simpler communication model</td>
                            <td>More structured message and role architecture</td>
                        </tr>
                        <tr>
                            <td>Security</td>
                            <td>Depends on implementation and external mechanisms</td>
                            <td>Security is incorporated into the protocol architecture</td>
                        </tr>
                        <tr>
                            <td>Role distribution</td>
                            <td>More centralized</td>
                            <td>More flexible</td>
                        </tr>
                    </tbody>
                </table>'
            ],

            'vardiff' => [
                'title' => 'What Is VarDiff in Mining | TM Wiki',
                'description' => 'VarDiff automatically changes share difficulty for miners according to their computing power and target submission rate.',
                'name' => 'VarDiff',
                'caption' => 'A mechanism that dynamically adjusts share difficulty to a miner’s hashrate.',
                'definition' => '<p><strong>VarDiff (Variable Difficulty)</strong> is a mechanism that automatically changes <span class="term" data-term="mining-pools/share-difficulty">share difficulty</span> to adapt the frequency of submitted shares to the computing power of an individual miner.</p>

                <p>Miners connected to the same pool can have very different hashrates. One participant may operate a single low-power device, while another may operate a large mining farm. If both used exactly the same share difficulty, the number of results submitted by each worker could differ dramatically.</p>

                <h3>Why VarDiff Is Used</h3>

                <p>The primary purpose of VarDiff is to maintain a practical share submission rate. The pool needs enough results from each worker to track its work statistically, while avoiding an excessive number of network messages.</p>

                <table>
                    <thead>
                        <tr>
                            <th>Miner Hashrate</th>
                            <th>Typical Adjustment</th>
                            <th>Goal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Low</td>
                            <td>Lower share difficulty</td>
                            <td>Receive shares frequently enough for tracking</td>
                        </tr>
                        <tr>
                            <td>High</td>
                            <td>Higher share difficulty</td>
                            <td>Avoid excessive result submissions</td>
                        </tr>
                    </tbody>
                </table>

                <h3>How Difficulty Changes</h3>

                <p>The pool monitors how frequently a worker submits shares. If results arrive too frequently, the pool can increase the difficulty. If shares arrive too infrequently, the difficulty can be reduced.</p>

                <p>VarDiff therefore attempts to keep the average interval between shares close to a target value defined by the pool.</p>

                <h3>VarDiff vs. Network Difficulty</h3>

                <p>VarDiff does not change the blockchain’s network difficulty. It operates only at the level of pool-assigned jobs.</p>

                <p>Network difficulty determines how difficult it is to find a complete block. Share difficulty determines how frequently the pool receives intermediate results from miners.</p>

                <p>Changing VarDiff therefore does not mean that a cryptocurrency has become harder or easier to mine. It changes only the pool’s internal work-accounting mechanism.</p>

                <h3>Practical Importance</h3>

                <p>A properly configured VarDiff mechanism helps reduce unnecessary network traffic while providing enough data to estimate worker hashrate. Inappropriate parameters can result in excessive message traffic, shares being submitted too rarely, or unnecessary load on pool infrastructure.</p>'
            ],
        ]
    ],

    'cooling' => [
        'title' => 'Mining Cooling Terms',
        'description' => 'Mining cooling glossary covering immersion cooling, hydro cooling, heat exchange, dielectric fluids and other terms.',
        'name' => 'Cooling',
        'caption' => 'Terms related to mining equipment cooling, including air, water and immersion cooling, heat exchange, coolants and other concepts.',
        'terms' => [
            'air-cooling' => [
                'title' => 'What Is Air Cooling | TM Wiki',
                'description' => 'Air cooling removes heat from mining equipment by using airflow, fans, heatsinks, and properly organized ventilation.',
                'name' => 'Air Cooling',
                'caption' => 'A cooling method that removes heat from mining equipment through moving air.',
                'definition' => '<p><strong>Air cooling</strong> is a method of removing heat from mining equipment in which heated components transfer thermal energy to air, while fans move that air through heatsinks and away from the equipment. It is one of the most common cooling methods used for ASIC miners and other computing hardware.</p>

                <p>During operation, mining chips continuously consume electrical power and convert a large part of that energy into heat. This heat must be removed continuously because excessive temperatures can reduce component stability and may cause automatic frequency reduction or equipment shutdown.</p>

                <h3>How Air Cooling Works</h3>

                <ol>
                    <li>Computing chips and other components generate heat.</li>
                    <li>Heat is transferred from the components to heatsinks through a thermal interface material.</li>
                    <li>Fans create airflow through the heatsinks.</li>
                    <li>The air absorbs heat from the heatsinks.</li>
                    <li>Heated air is discharged from the enclosure or facility.</li>
                    <li>Cooler air enters and repeats the cycle.</li>
                </ol>

                <h3>What Determines Efficiency</h3>

                <p>The main factor is the ability of the system to remove the generated <span class="term" data-term="cooling/thermal-load">thermal load</span>. With identical hardware, cooling performance can vary significantly depending on air temperature, airflow, and the organization of hot and cold air streams.</p>

                <p>Ambient temperature is especially important. The higher the ambient temperature, the smaller the temperature difference between the equipment and incoming air. As a result, more airflow or a more capable cooling system may be required to remove the same amount of heat.</p>

                <p>Mining facilities must also prevent hot exhaust air from returning to equipment air intakes. Otherwise, the actual inlet temperature can increase rapidly.</p>

                <h3>Advantages and Limitations</h3>

                <ul>
                    <li>simple system architecture;</li>
                    <li>relatively low infrastructure cost;</li>
                    <li>no liquid coolant is required;</li>
                    <li>easy fan replacement and maintenance;</li>
                    <li>high ventilation requirements at high equipment density;</li>
                    <li>significant noise from high-speed fans.</li>
                </ul>

                <h3>Air Cooling in Mining Facilities</h3>

                <p>For a small installation, sufficient fresh-air supply and hot-air exhaust may be enough. In a large facility, air cooling becomes part of the engineering infrastructure and may include ducts, exhaust systems, filtration, and automated ventilation control.</p>

                <p>At high equipment density, moving large volumes of air can itself consume significant electrical power. Therefore, mining operators need to consider the energy consumption of the cooling infrastructure in addition to the consumption of the ASIC miners.</p>

                <p>Air cooling remains a common solution for mining facilities, while higher <span class="term" data-term="cooling/thermal-load">thermal loads</span> may justify <span class="term" data-term="cooling/hydro-cooling">hydro cooling</span>, <span class="term" data-term="cooling/immersion-cooling">immersion cooling</span>, or other specialized technologies.</p>'
            ],

            'immersion-cooling' => [
                'title' => 'What Is Immersion Cooling | TM Wiki',
                'description' => 'Immersion cooling places mining equipment in dielectric fluid to transfer heat directly from components into the cooling medium.',
                'name' => 'Immersion Cooling',
                'caption' => 'A cooling method that submerges equipment in electrically non-conductive dielectric fluid.',
                'definition' => '<p><strong>Immersion cooling</strong> is a heat-removal technology in which mining equipment or selected components are submerged in a specially designed electrically non-conductive fluid. The fluid directly contacts heated surfaces and transfers their thermal energy toward a heat exchanger or another part of the cooling system.</p>

                <p>The main difference between immersion cooling and air cooling is the medium that directly receives heat from the equipment. Instead of moving large volumes of air, the system uses a specialized <span class="term" data-term="cooling/dielectric-fluid">dielectric fluid</span> that can contact electrical components without creating a conventional conductive path.</p>

                <h3>How Immersion Cooling Works</h3>

                <ol>
                    <li>ASIC equipment is installed inside a dedicated tank.</li>
                    <li>The equipment is submerged in compatible <span class="term" data-term="cooling/dielectric-fluid">dielectric fluid</span>.</li>
                    <li>Heat from computing components is transferred to the fluid.</li>
                    <li>Heated fluid moves through the cooling system.</li>
                    <li>A heat exchanger transfers the thermal energy to another circuit or the environment.</li>
                    <li>Cooled fluid returns to the equipment.</li>
                </ol>

                <h3>Single-Phase and Two-Phase Systems</h3>

                <p>In single-phase immersion systems, the working fluid remains liquid throughout the cooling cycle. It absorbs heat from the equipment, moves to the heat exchanger, releases that heat, and returns to the tank.</p>

                <p>In two-phase systems, the working fluid evaporates when heated. The vapor rises to a condensing area, releases heat, and returns to liquid form. This approach uses a phase change as part of the heat-transfer process.</p>

                <h3>Advantages</h3>

                <ul>
                    <li>high heat-transfer capability;</li>
                    <li>high equipment density can be supported;</li>
                    <li>reduced dependence on large air volumes;</li>
                    <li>reduced reliance on conventional high-speed fans;</li>
                    <li>more uniform heat transfer across immersed components.</li>
                </ul>

                <h3>Infrastructure Requirements</h3>

                <p>An immersion system requires dedicated tanks, compatible fluid, heat exchangers, and an organized <span class="term" data-term="cooling/cooling-loop">cooling loop</span>. Material compatibility must also be considered for circuit boards, cables, seals, plastics, adhesives, and metals.</p>

                <p>Immersion cooling is particularly relevant where the equipment produces a high <span class="term" data-term="cooling/thermal-load">thermal load</span>. It does not eliminate the need to reject heat from the facility; instead, it changes how heat is transferred from the mining equipment to the external heat-rejection system.</p>'
            ],

            'hydro-cooling' => [
                'title' => 'What Is Hydro Cooling in Mining | TM Wiki',
                'description' => 'Hydro cooling uses circulating liquid to remove heat from high-load mining equipment through an engineered cooling system.',
                'name' => 'Hydro Cooling',
                'caption' => 'An engineered liquid cooling system that circulates coolant to remove heat from mining equipment.',
                'definition' => '<p><strong>Hydro cooling</strong> is a heat-removal technology based on the circulation of liquid coolant through an engineered cooling system. In mining, the term commonly refers to systems that remove heat from high-load equipment through liquid circulation rather than relying primarily on large volumes of moving air.</p>

                <p>The core of the system is a <span class="term" data-term="cooling/cooling-loop">cooling loop</span> through which <span class="term" data-term="cooling/coolant">coolant</span> moves. The coolant receives heat from the equipment, travels to a heat exchanger, releases the thermal energy, and returns to the equipment.</p>

                <h3>Main Components</h3>

                <ul>
                    <li>cooling blocks;</li>
                    <li>pumps;</li>
                    <li>piping;</li>
                    <li>coolant;</li>
                    <li>heat exchangers;</li>
                    <li>temperature, pressure, and flow sensors;</li>
                    <li>control and protection systems.</li>
                </ul>

                <h3>Cooling Capacity</h3>

                <p>The system must have sufficient <span class="term" data-term="cooling/cooling-capacity">cooling capacity</span> to match the equipment <span class="term" data-term="cooling/thermal-load">thermal load</span>. If the system cannot continuously remove the heat generated by the miners, coolant and component temperatures will increase.</p>

                <p><span class="term" data-term="cooling/delta-t">Delta T</span> between coolant inlet and outlet is another important operating parameter. Combined with flow rate, it helps characterize how much heat the coolant is receiving from the equipment.</p>

                <h3>Mining Applications</h3>

                <p>Hydro cooling can be useful in high-density mining installations where moving large amounts of air would require substantial infrastructure and auxiliary power.</p>

                <p>However, liquid infrastructure is more complex than basic air cooling. The system requires leak protection, pump maintenance, coolant monitoring, heat exchanger maintenance, and continuous control of operating parameters.</p>'
            ],

            'direct-to-chip-cooling' => [
                'title' => 'What Is Direct-to-Chip Cooling | TM Wiki',
                'description' => 'Direct-to-chip cooling transfers heat directly from computing chips through dedicated liquid cooling blocks.',
                'name' => 'Direct-to-Chip Cooling',
                'caption' => 'A cooling architecture that transfers heat directly from computing chips into a liquid cooling system.',
                'definition' => '<p><strong>Direct-to-chip cooling</strong> is a liquid cooling architecture in which heat from a computing chip is transferred directly to a dedicated cooling block installed on or immediately adjacent to the chip. In mining, this approach can efficiently remove heat from ASIC chips with high power density.</p>

                <p>The main principle is to minimize the thermal path between the heat source and the <span class="term" data-term="cooling/coolant">coolant</span>. Instead of transferring large amounts of heat into air, the chip transfers energy to a cooling block through which liquid flows.</p>

                <h3>How Direct-to-Chip Cooling Works</h3>

                <ol>
                    <li>The computing chip generates heat during operation.</li>
                    <li>Heat passes through the thermal interface material.</li>
                    <li>The cooling block receives heat from the chip.</li>
                    <li>Circulating coolant absorbs the heat.</li>
                    <li>Heated coolant leaves through the cooling loop.</li>
                    <li>The coolant is cooled and returned to the equipment.</li>
                </ol>

                <h3>Why the Thermal Interface Matters</h3>

                <p>Even an efficient liquid cooling system has a physical interface between the chip and cooling block. The thermal resistance of this interface should be minimized. The quality and installation of the thermal interface material therefore directly affects heat transfer.</p>

                <h3>Advantages</h3>

                <ul>
                    <li>short thermal path from chip to coolant;</li>
                    <li>high heat-removal density;</li>
                    <li>lower dependence on large airflow volumes;</li>
                    <li>centralized heat rejection;</li>
                    <li>support for compact high-density installations.</li>
                </ul>

                <p>Direct-to-chip cooling differs from <span class="term" data-term="cooling/immersion-cooling">immersion cooling</span>. In direct-to-chip systems, coolant flows through dedicated cooling elements attached to the chips. In immersion systems, the equipment itself is placed directly in dielectric fluid.</p>'
            ],

            'dielectric-fluid' => [
                'title' => 'What Is Dielectric Fluid | TM Wiki',
                'description' => 'Dielectric fluid is a non-conductive coolant used to transfer heat from electrical and mining equipment.',
                'name' => 'Dielectric Fluid',
                'caption' => 'An electrically non-conductive fluid used to transfer heat in specialized cooling systems.',
                'definition' => '<p><strong>Dielectric fluid</strong> is a liquid with low electrical conductivity that can be used as a <span class="term" data-term="cooling/coolant">coolant</span> around electrical components. In mining, dielectric fluids are especially important for <span class="term" data-term="cooling/immersion-cooling">immersion cooling</span>, where mining equipment can be placed directly into the fluid.</p>

                <p>Ordinary water is not intended for direct contact with powered electronics because its electrical properties and dissolved impurities can create conductive paths. Dielectric fluids provide electrical insulation while also transporting heat away from components.</p>

                <h3>Important Properties</h3>

                <ul>
                    <li>dielectric strength;</li>
                    <li>heat capacity;</li>
                    <li>thermal conductivity;</li>
                    <li>viscosity;</li>
                    <li>operating temperature range;</li>
                    <li>chemical stability;</li>
                    <li>compatibility with equipment materials.</li>
                </ul>

                <h3>Role in Immersion Cooling</h3>

                <p>When ASIC equipment is immersed, the fluid contacts many heated surfaces directly. It absorbs heat from the components and transports that energy to a heat exchanger or another part of the <span class="term" data-term="cooling/cooling-loop">cooling loop</span>.</p>

                <p>Fluid selection must consider more than thermal performance. Long-term compatibility with plastics, cables, seals, adhesives, and metals is also important. Changes in fluid properties over time can reduce system performance.</p>

                <h3>Dielectric Fluid vs Coolant</h3>

                <p>Dielectric fluid is a specific type of <span class="term" data-term="cooling/coolant">coolant</span>. Not every coolant is dielectric. For example, some water-based coolants transfer heat efficiently but are not designed for direct immersion of electrical equipment.</p>

                <p>A complete system therefore has to consider the electrical, thermal, and chemical properties of the working fluid simultaneously.</p>'
            ],

            'coolant' => [
                'title' => 'What Is Coolant in Mining Cooling | TM Wiki',
                'description' => 'Coolant transfers heat from mining equipment to a heat exchanger within a liquid cooling system.',
                'name' => 'Coolant',
                'caption' => 'A working fluid or medium that transports thermal energy inside a cooling system.',
                'definition' => '<p><strong>Coolant</strong> is the working medium that receives heat from equipment and transports it to a location where that heat can be rejected. In liquid mining cooling systems, coolant is usually a specialized fluid circulating between the equipment and heat exchanger.</p>

                <p>After absorbing heat, the coolant moves through the <span class="term" data-term="cooling/cooling-loop">cooling loop</span> and transfers thermal energy to a heat exchanger. After cooling, it returns to the equipment and repeats the cycle.</p>

                <h3>Important Coolant Properties</h3>

                <ul>
                    <li>heat capacity;</li>
                    <li>thermal conductivity;</li>
                    <li>viscosity;</li>
                    <li>freezing and boiling temperatures;</li>
                    <li>chemical stability;</li>
                    <li>material compatibility.</li>
                </ul>

                <p>The amount of heat a given volume of coolant can carry for a specified temperature increase affects the potential <span class="term" data-term="cooling/cooling-capacity">cooling capacity</span> of the system. Flow rate and <span class="term" data-term="cooling/delta-t">Delta T</span> are also important.</p>

                <h3>Types of Coolant</h3>

                <p><span class="term" data-term="cooling/hydro-cooling">Water cooling</span> uses water or a water-based coolant. <span class="term" data-term="cooling/immersion-cooling">Immersion cooling</span> uses specialized <span class="term" data-term="cooling/dielectric-fluid">dielectric fluids</span> designed for direct contact with electrical equipment.</p>

                <p>Coolant selection affects heat transfer as well as pump requirements, piping, filtration, maintenance, and material compatibility. An unsuitable coolant can cause corrosion, seal degradation, deposits, or reduced heat-transfer performance.</p>

                <h3>Coolant Monitoring</h3>

                <p>Industrial systems monitor coolant temperature, pressure, flow rate, and condition. Changes can indicate leaks, blocked filters, pump degradation, or reduced heat exchanger performance.</p>'
            ],

            'cooling-loop' => [
                'title' => 'What Is a Cooling Loop | TM Wiki',
                'description' => 'A cooling loop circulates coolant between mining equipment, pumps, and heat exchangers to remove heat.',
                'name' => 'Cooling Loop',
                'caption' => 'A circulation path that moves coolant between heat sources and heat rejection equipment.',
                'definition' => '<p><strong>Cooling loop</strong> is an organized circulation path that moves <span class="term" data-term="cooling/coolant">coolant</span> between mining equipment and the heat rejection system. In mining installations, the loop may be closed or may consist of multiple connected circuits.</p>

                <p>The main purpose of the loop is to continuously transport heat from the equipment to a heat exchanger. After releasing the heat, cooled coolant returns to the miners and repeats the process.</p>

                <h3>Typical Cooling Cycle</h3>

                <ol>
                    <li>Coolant enters the cooling hardware.</li>
                    <li>It absorbs heat from the equipment.</li>
                    <li>A pump moves the heated coolant through the system.</li>
                    <li>The coolant reaches a heat exchanger.</li>
                    <li>Thermal energy is transferred to another circuit or the environment.</li>
                    <li>Cooled coolant returns to the equipment.</li>
                </ol>

                <h3>Main Components</h3>

                <ul>
                    <li>piping;</li>
                    <li>pumps;</li>
                    <li>cooling blocks;</li>
                    <li>heat exchangers;</li>
                    <li>expansion tanks;</li>
                    <li>filters;</li>
                    <li>temperature, pressure, and flow sensors.</li>
                </ul>

                <p>Loop performance depends on coolant flow rate, hydraulic resistance, pump characteristics, and heat exchanger performance. These parameters must match the actual equipment <span class="term" data-term="cooling/thermal-load">thermal load</span>.</p>

                <h3>Temperature Difference</h3>

                <p><span class="term" data-term="cooling/delta-t">Delta T</span> between the inlet and outlet is an important operating parameter. It shows how much the coolant temperature changes while passing through the equipment.</p>

                <p>For large mining facilities, cooling loop reliability is critical. Pump failure, leakage, or insufficient flow can cause temperatures to increase across a large number of machines simultaneously.</p>'
            ],

            'cooling-capacity' => [
                'title' => 'What Is Cooling Capacity | TM Wiki',
                'description' => 'Cooling capacity indicates how much thermal energy a cooling system can remove under specified operating conditions.',
                'name' => 'Cooling Capacity',
                'caption' => 'The amount of heat a cooling system can continuously remove under defined conditions.',
                'definition' => '<p><strong>Cooling capacity</strong> is a characteristic that indicates how much thermal energy a cooling system can remove from equipment under specified operating conditions. In mining infrastructure, the cooling capacity must be sufficient for the combined <span class="term" data-term="cooling/thermal-load">thermal load</span> of all operating equipment.</p>

                <p>If the equipment generates more heat than the system can continuously remove, component and coolant temperatures will increase. For this reason, cooling systems are normally designed with additional capacity rather than being operated permanently at their absolute limit.</p>

                <h3>What Determines Cooling Capacity</h3>

                <ul>
                    <li>inlet air or coolant temperature;</li>
                    <li>air or liquid flow rate;</li>
                    <li>coolant heat capacity;</li>
                    <li>heat exchange surface area;</li>
                    <li>heat exchanger performance;</li>
                    <li>fan or pump capacity;</li>
                    <li>ambient temperature.</li>
                </ul>

                <p>In liquid systems, the properties of the <span class="term" data-term="cooling/coolant">coolant</span> and the system <span class="term" data-term="cooling/delta-t">Delta T</span> are important. In air systems, inlet temperature, airflow, and the ability of heatsinks to transfer heat into the air are key factors.</p>

                <h3>Cooling Capacity in Mining</h3>

                <p>The approximate thermal load of ASIC equipment is close to its electrical power consumption. Therefore, a mining installation consuming approximately 1 MW of electrical power can generate roughly 1 MW of heat that must be continuously rejected.</p>

                <p>The total facility load may also include pumps, fans, power supplies, and other infrastructure. The cooling system should therefore be designed against the total thermal load of the installation rather than only the nominal power of the ASICs.</p>

                <h3>Capacity Margin</h3>

                <p>A practical cooling system should have sufficient margin for seasonal changes in ambient temperature, filter contamination, changes in equipment load, and degradation of pumps, fans, and heat exchangers.</p>'
            ],

            'heat-dissipation' => [
                'title' => 'What Is Heat Dissipation | TM Wiki',
                'description' => 'Heat dissipation is the process of transferring thermal energy from mining equipment to the environment or an external cooling system.',
                'name' => 'Heat Dissipation',
                'caption' => 'The process of removing thermal energy generated by mining equipment.',
                'definition' => '<p><strong>Heat dissipation</strong> is the process of removing thermal energy from mining equipment and transferring it to the environment or to another cooling system that performs the final heat rejection. Every computing system that consumes electrical power must ultimately dispose of the heat generated during operation.</p>

                <p>In an ASIC miner, heat is generated mainly by computing chips and associated electronic components. The energy must first move from the heat source to a cooling element, then transfer into air or <span class="term" data-term="cooling/coolant">coolant</span>, and finally leave the equipment and facility.</p>

                <h3>Stages of Heat Dissipation</h3>

                <ol>
                    <li>Heat is generated inside electronic components.</li>
                    <li>Thermal energy moves to a heatsink or cooling block.</li>
                    <li>Heat transfers to air or <span class="term" data-term="cooling/coolant">coolant</span>.</li>
                    <li>The heated medium is transported away.</li>
                    <li>Heat is ultimately released to the environment.</li>
                </ol>

                <p>All stages matter. A powerful fan cannot compensate for poor thermal contact between a chip and heatsink, while an efficient coolant cannot solve insufficient heat exchanger capacity.</p>

                <h3>Heat Dissipation and Thermal Load</h3>

                <p>The cooling infrastructure must match the equipment <span class="term" data-term="cooling/thermal-load">thermal load</span>. If a facility produces 500 kW of heat, its cooling infrastructure must be capable of continuously rejecting approximately that amount of thermal energy, with an appropriate operating margin.</p>

                <p>Large systems may use several heat-transfer stages. An internal loop can collect heat from the miners while an external loop transfers that energy to outside air through a heat exchanger.</p>

                <h3>Why Heat Dissipation Matters</h3>

                <p>Insufficient heat dissipation causes component temperatures to rise. This can contribute to unstable operation, hardware errors, and <span class="term" data-term="equipment-specifications/thermal-throttling">thermal throttling</span>. Effective heat dissipation is therefore an important part of mining infrastructure reliability.</p>'
            ],

            'thermal-load' => [
                'title' => 'What Is Thermal Load in Mining | TM Wiki',
                'description' => 'Thermal load is the amount of heat generated by mining equipment and other sources that the cooling system must continuously remove.',
                'name' => 'Thermal Load',
                'caption' => 'The amount of thermal energy that must be continuously removed from operating equipment.',
                'definition' => '<p><strong>Thermal load</strong> is the amount of thermal energy generated by equipment per unit of time that must be removed by the cooling system. For mining facilities, thermal load is one of the main parameters used when designing ventilation, liquid cooling, and heat rejection infrastructure.</p>

                <p>Almost all electrical power consumed by an ASIC miner ultimately becomes heat. Therefore, equipment power consumption is an important starting point for estimating the thermal load of a mining installation.</p>

                <h3>How Thermal Load Is Estimated</h3>

                <p>A basic estimate can be made by adding the electrical power consumption of all operating devices. For example, if a group of miners consumes a combined 1 MW, the approximate thermal output of that equipment is also close to 1 MW.</p>

                <p>In a real facility, pumps, fans, power supplies, networking equipment, and other infrastructure also consume power and contribute heat. Therefore, total room or building thermal load can be higher than the load generated directly by the ASIC miners.</p>

                <h3>Thermal Load and Cooling</h3>

                <p>The cooling system must provide sufficient <span class="term" data-term="cooling/cooling-capacity">cooling capacity</span>. If cooling capacity is lower than the actual thermal load, temperatures will continue to rise until operating conditions change or equipment reduces its output.</p>

                <p>In liquid systems, thermal load is related to coolant flow rate and <span class="term" data-term="cooling/delta-t">temperature difference</span>. In air systems, airflow and the temperature difference between inlet and outlet air are important parameters.</p>

                <h3>Why Capacity Margin Matters</h3>

                <p>Designing exactly for nominal load leaves little room for changing ambient temperatures, filter contamination, equipment upgrades, changes in operating power, and degradation of cooling components.</p>'
            ],

            'thermal-paste' => [
                'title' => 'What Is Thermal Paste | TM Wiki',
                'description' => 'Thermal paste fills microscopic gaps between a chip and heatsink and reduces thermal resistance at the contact surface.',
                'name' => 'Thermal Paste',
                'caption' => 'A paste-like thermal interface material used to improve heat transfer from a chip to a heatsink.',
                'definition' => '<p><strong>Thermal paste</strong> is a paste-like thermal interface material applied between a heat-generating component and a cooling surface. In mining hardware, it can be used between ASIC chips and heatsinks or other heat-transfer elements.</p>

                <p>Chip and heatsink surfaces contain microscopic irregularities. Without an interface material, small air gaps remain between the surfaces. Thermal paste fills these gaps and provides a more effective thermal path.</p>

                <h3>How Thermal Paste Affects Cooling</h3>

                <p>Thermal paste does not cool the chip by itself. Its purpose is to reduce thermal resistance between the heat source and the heatsink. The heatsink or cooling block then transfers the heat into air or <span class="term" data-term="cooling/coolant">coolant</span>.</p>

                <h3>Why Layer Thickness Matters</h3>

                <p>The purpose of thermal paste is to fill microscopic surface irregularities rather than create a thick thermal layer. Excessive paste does not automatically improve cooling and can increase the distance through which heat must travel.</p>

                <h3>Maintenance</h3>

                <p>Thermal paste can change over time due to prolonged exposure to heat. It may dry out, migrate, or lose some of its ability to maintain an effective contact layer.</p>

                <p>When servicing ASIC equipment, the correct application method depends on the board and cooling assembly design. Incorrect application can produce uneven thermal contact and temperature differences between individual chips.</p>'
            ],

            'thermal-pad' => [
                'title' => 'What Is a Thermal Pad | TM Wiki',
                'description' => 'A thermal pad transfers heat between a component and cooling surface while filling a defined physical gap.',
                'name' => 'Thermal Pad',
                'caption' => 'An elastic thermal interface material used to transfer heat across a physical gap.',
                'definition' => '<p><strong>Thermal pad</strong> is a soft or elastic thermal interface material designed to transfer heat between a component and a heatsink or other cooling surface. Unlike thermal paste, a pad has a defined physical thickness and can compensate for a larger gap between two surfaces.</p>

                <p>Thermal pads are commonly used where a component cannot directly contact the heatsink. The pad compresses during assembly and provides a thermal path between the two surfaces.</p>

                <h3>Where Thermal Pads Are Used</h3>

                <ul>
                    <li>electronic components separated from a heatsink by a defined gap;</li>
                    <li>chips or components connected to metal heat spreaders;</li>
                    <li>cooling assemblies where surfaces have different heights;</li>
                    <li>selected ASIC miner and power supply designs.</li>
                </ul>

                <h3>Thermal Pad vs Thermal Paste</h3>

                <p><span class="term" data-term="cooling/thermal-paste">Thermal paste</span> is primarily intended to fill microscopic surface irregularities between two closely contacting surfaces. A thermal pad provides both thermal transfer and physical gap filling.</p>

                <p>For this reason, pads are selected not only by thermal conductivity but also by thickness, compressibility, and mechanical properties. A pad that is too thick or too rigid can create excessive mechanical pressure or interfere with other components.</p>

                <h3>Importance in Mining Hardware</h3>

                <p>The condition of thermal pads can affect the temperature of individual components in ASIC miners. Aging, loss of elasticity, or incorrect pad thickness can reduce heat transfer.</p>

                <p>Replacement requires a pad with appropriate thickness and thermal characteristics. A thermal pad should not automatically be replaced with a thick layer of thermal paste because the two materials serve different mechanical and thermal functions.</p>'
            ],

            'delta-t' => [
                'title' => 'What Is Delta T in Cooling | TM Wiki',
                'description' => 'Delta T is the temperature difference between two points in a cooling system and is used to evaluate heat transfer.',
                'name' => 'Delta T',
                'caption' => 'The temperature difference between the inlet and outlet of a cooling system or component.',
                'definition' => '<p><strong>Delta T</strong> is the temperature difference between two selected points in a cooling system. In mining, the term is commonly used to compare the temperature of air or coolant entering and leaving equipment or a specific cooling component.</p>

                <p>For example, if coolant enters a cooling block at 30 °C and leaves at 35 °C, the Delta T is 5 °C. This means that the coolant temperature increased by five degrees while passing through the equipment.</p>

                <h3>How Delta T Is Calculated</h3>

                <p>The basic formula is:</p>

                <p><strong>Delta T = outlet temperature − inlet temperature</strong></p>

                <p>Depending on the system, the measurement may involve air, water, or another <span class="term" data-term="cooling/coolant">coolant</span>. The exact measurement points should always be specified.</p>

                <h3>Delta T in Liquid Cooling</h3>

                <p>In liquid cooling, Delta T shows how much the coolant heats up while passing through the equipment. Together with coolant flow rate and heat capacity, it can be used to estimate the amount of thermal energy transferred by the coolant.</p>

                <p>A large Delta T does not automatically mean that the cooling system is performing well or poorly. Flow rate, component temperature, coolant properties, and system design must also be considered.</p>

                <h3>Delta T in Air Cooling</h3>

                <p>In air cooling, operators can compare inlet temperature with outlet temperature. The difference shows how much the air has heated while passing through the mining equipment.</p>

                <h3>Why Delta T Matters</h3>

                <p>Delta T is useful for cooling system design and diagnostics. Changes in the value can indicate changes in flow rate, equipment thermal load, ambient conditions, or heat exchanger performance.</p>

                <p>For meaningful analysis, Delta T should be evaluated together with <span class="term" data-term="cooling/cooling-capacity">cooling capacity</span>, cooling-medium flow rate, and actual <span class="term" data-term="cooling/thermal-load">thermal load</span>.</p>'
            ],
        ]
    ],

    'mining-infrastructure' => [
        'title' => 'Mining Infrastructure Terms',
        'description' => 'Mining infrastructure glossary covering mining farms, hosting, data centers, PUE, SLA and other terms.',
        'name' => 'Mining Infrastructure',
        'caption' => 'Terms related to industrial mining infrastructure, including mining farms, hosting, data centers, containers, power systems, PUE and other concepts.',
        'terms' => [
            'mining-farm' => [
                'title' => 'What Is a Mining Farm | TM Wiki',
                'description' => 'A mining farm is a group of mining hardware and infrastructure organized for large-scale cryptocurrency mining.',
                'name' => 'Mining Farm',
                'caption' => 'A coordinated group of mining hardware and infrastructure operating as a single mining site.',
                'definition' => '<p><strong>Mining Farm</strong> is a group of mining hardware, power systems, cooling systems, networking equipment, and management tools organized for the simultaneous operation of multiple mining devices.</p>

                <p>In a small setup, a farm may consist of only a few devices located in one room. At industrial scale, it can include hundreds or thousands of miners distributed across racks, containers, or dedicated areas. A mining farm therefore represents more than a collection of <span class="term" data-term="mining-equipment/mining-hardware">mining hardware</span>: it is an infrastructure system designed to keep the equipment operating continuously.</p>

                <h3>Components of a Mining Farm</h3>

                <p>The exact configuration depends on the scale of the operation and the type of equipment being used. A mining farm commonly includes:</p>

                <ul>
                    <li><span class="term" data-term="mining-equipment/asic-miner">ASIC miners</span>, GPU miners, or other computing devices;</li>
                    <li>electrical distribution and protection equipment;</li>
                    <li>cooling and heat-removal systems;</li>
                    <li>networking equipment and internet connectivity;</li>
                    <li>monitoring and <span class="term" data-term="mining-infrastructure/remote-management">remote management</span> systems;</li>
                    <li>structures for mounting and organizing equipment;</li>
                    <li>backup infrastructure supporting high <span class="term" data-term="equipment-specifications/uptime">uptime</span>.</li>
                </ul>

                <h3>How a Mining Farm Operates</h3>

                <p>Each miner performs its own computational work while the infrastructure provides power, cooling, networking, and monitoring. The equipment may connect to a <span class="term" data-term="mining-pools/mining-pool">mining pool</span> or operate through another mining method.</p>

                <p>As the number of devices increases, computing power is no longer the only limiting factor. The operator must also provide sufficient power capacity, heat removal, network connectivity, and maintenance access.</p>

                <h3>Scaling a Mining Farm</h3>

                <p>Adding miners increases more than the total hashrate. It also increases electrical and thermal loads. If the electrical or cooling infrastructure is not designed for the additional load, the farm may be unable to operate all installed devices continuously.</p>

                <p>Large facilities therefore plan electrical capacity, <span class="term" data-term="cooling/cooling-capacity">cooling capability</span>, network infrastructure, and infrastructure reserves before expanding the number of miners.</p>

                <h3>Key Infrastructure Factors</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Practical role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Power system</td>
                            <td>Determines how much equipment can be operated safely.</td>
                        </tr>
                        <tr>
                            <td>Cooling</td>
                            <td>Removes heat and helps maintain acceptable operating temperatures.</td>
                        </tr>
                        <tr>
                            <td>Network</td>
                            <td>Connects miners with pools and management systems.</td>
                        </tr>
                        <tr>
                            <td>Monitoring</td>
                            <td>Helps detect failures and abnormal operating conditions.</td>
                        </tr>
                        <tr>
                            <td>Equipment placement</td>
                            <td>Determines density, airflow, and maintenance access.</td>
                        </tr>
                    </tbody>
                </table>

                <p>A mining farm is therefore an integrated infrastructure system in which computing hardware is only one component. Its practical performance depends on how well power, cooling, networking, physical layout, and management systems work together.</p>'
            ],

            'data-center' => [
                'title' => 'What Is a Data Center | TM Wiki',
                'description' => 'A data center is an engineered facility for computing equipment, including specialized facilities designed for high-density mining loads.',
                'name' => 'Data Center',
                'caption' => 'An engineered facility designed for reliable operation of computing and network equipment.',
                'definition' => '<p><strong>Data Center</strong> is a specialized facility designed to house computing and networking equipment while providing power, cooling, connectivity, physical security, and other supporting systems.</p>

                <p>In mining, a data center can be used as the infrastructure location for a large number of <span class="term" data-term="mining-equipment/mining-hardware">mining hardware</span> devices. However, not every data center is suitable for mining because mining hardware can create high continuous electrical and thermal loads.</p>

                <h3>Main Characteristics</h3>

                <ul>
                    <li>reliable electrical supply;</li>
                    <li>controlled cooling and heat removal;</li>
                    <li>structured network infrastructure;</li>
                    <li>physical access control and security;</li>
                    <li>monitoring of technical systems;</li>
                    <li>maintenance and equipment replacement access.</li>
                </ul>

                <h3>Data Centers and Mining</h3>

                <p>Mining loads differ from many conventional computing workloads. ASIC miners can operate continuously at high power levels and convert most of their electrical consumption into heat. As a result, mining-oriented data centers require sufficient power capacity and heat-removal capability.</p>

                <p>Equipment density is another important factor. Increasing the amount of computing hardware per unit of floor space increases both electrical and thermal requirements.</p>

                <h3>Infrastructure Reliability</h3>

                <p>Continuous mining depends on the availability of power, cooling, and network systems. A power failure, overheating event, or network outage can stop equipment from producing hashrate and increase downtime.</p>

                <p>For this reason, data-center evaluations can include electrical redundancy, cooling capacity, monitoring systems, network connectivity, maintenance procedures, and recovery capabilities.</p>

                <h3>Mining Hosting</h3>

                <p>A data center may be owned by the mining operator or provide infrastructure to third-party equipment owners. In the latter case, equipment may be deployed under a <span class="term" data-term="mining-infrastructure/mining-hosting">mining hosting</span> model, with the facility operator providing part of the required infrastructure.</p>'
            ],

            'mining-container' => [
                'title' => 'What Is a Mining Container | TM Wiki',
                'description' => 'A mining container is a specialized modular unit designed to house ASIC miners and supporting electrical, cooling, and network systems.',
                'name' => 'Mining Container',
                'caption' => 'A specialized container module for housing and operating cryptocurrency mining equipment.',
                'definition' => '<p><strong>Mining Container</strong> is a specially equipped container module designed to house and operate cryptocurrency mining hardware. Depending on the design, it can contain electrical distribution, ventilation, cooling, networking, monitoring, and equipment mounting systems.</p>

                <p>The container represents a physical infrastructure unit. Multiple containers can be installed on the same site and connected to shared power and network systems. This makes the container a modular building block for larger mining deployments.</p>

                <h3>Main Components</h3>

                <ul>
                    <li>mounting structures for mining hardware;</li>
                    <li>electrical distribution and protection equipment;</li>
                    <li>ventilation or another cooling system;</li>
                    <li>networking equipment;</li>
                    <li>temperature and equipment-state sensors;</li>
                    <li>controls for electrical and auxiliary systems.</li>
                </ul>

                <h3>Thermal Load</h3>

                <p>Most of the electrical energy consumed by mining hardware ultimately becomes heat. As a result, the practical capacity of a container depends not only on physical space but also on the amount of heat that the cooling system can remove.</p>

                <p>With air cooling, fan capacity, airflow organization, inlet conditions, and ambient temperature are important. Other container designs may use alternative cooling architectures depending on the equipment and operating environment.</p>

                <h3>Electrical System</h3>

                <p>The internal electrical distribution system must support the combined load of the installed miners. Design considerations include device power consumption, circuit limits, phase distribution, protection equipment, and operating reserve.</p>

                <p>The container therefore cannot be evaluated separately from the external electrical infrastructure. Even a fully equipped container requires an external power source with sufficient capacity.</p>

                <h3>Scaling</h3>

                <p>The modular structure is particularly useful for expansion. Instead of rebuilding an existing facility, an operator can add additional containers when sufficient power, network, and site infrastructure is available.</p>'
            ],

            'mining-hosting' => [
                'title' => 'What Is Mining Hosting | TM Wiki',
                'description' => 'Mining hosting is a service in which mining hardware is deployed at a third-party site that provides power, cooling, networking, and infrastructure.',
                'name' => 'Mining Hosting',
                'caption' => 'A service model in which mining hardware is operated at a specialized third-party facility.',
                'definition' => '<p><strong>Mining Hosting</strong> is a service model in which the owner of mining hardware places the equipment at a third-party mining facility. The hosting operator provides some or all of the infrastructure required to operate the hardware, while ownership of the equipment may remain with the customer.</p>

                <p>Depending on the agreement, the operator may provide electricity, physical space, cooling, network connectivity, monitoring, security, installation, maintenance, and repair services. The exact scope is determined by the hosting contract.</p>

                <h3>Typical Hosting Components</h3>

                <ul>
                    <li>physical placement of mining equipment;</li>
                    <li>electrical connection;</li>
                    <li>cooling and ventilation;</li>
                    <li>network connectivity;</li>
                    <li>equipment monitoring;</li>
                    <li>site access or technical support;</li>
                    <li>in some models, installation and maintenance.</li>
                </ul>

                <h3>Hosting Costs</h3>

                <p>Hosting can be priced in several ways. A common structure is a charge based on electricity consumption combined with infrastructure or service fees. Other agreements may use a fixed rate per device, kilowatt, or another agreed unit.</p>

                <p>When evaluating a hosting agreement, the headline electricity price is not necessarily the total operating cost. Additional charges may apply to maintenance, repairs, installation, logistics, minimum consumption, or other services.</p>

                <h3>Infrastructure Dependency</h3>

                <p>Mining hosting allows an equipment owner to avoid building and operating a private mining facility. At the same time, the owner becomes dependent on the hosting operator for important infrastructure services.</p>

                <p>Power availability, cooling quality, maintenance procedures, access rules, outage handling, and transparency of billing are therefore important operational considerations.</p>

                <p>Mining hosting should be distinguished from operating a fully owned mining site because the infrastructure is provided as a service by another operator.</p>'
            ],

            'three-phase-power' => [
                'title' => 'What Is Three-Phase Power | TM Wiki',
                'description' => 'Three-phase power is an electrical supply system with three phases, widely used to distribute large loads at mining facilities.',
                'name' => 'Three-Phase Power',
                'caption' => 'A three-phase electrical supply system commonly used for distributing large industrial loads.',
                'definition' => '<p><strong>Three-Phase Power</strong> is an alternating-current electrical system that uses three phases separated by a defined phase angle. It is widely used in industrial and commercial power distribution because it is well suited to substantial electrical loads.</p>

                <p>In mining infrastructure, three-phase power can be used to distribute large electrical loads across a facility and supply equipment through an appropriately designed electrical system.</p>

                <h3>Why Three-Phase Systems Are Used</h3>

                <p>The main practical benefit is efficient transmission and distribution of substantial amounts of power. On a large mining site, equipment loads can be distributed across the available phases so that the electrical system remains within its design limits.</p>

                <p>The presence of three phases does not automatically increase the available power. The actual limit is determined by the complete electrical chain, from the grid connection through transformers, distribution equipment, and internal circuits.</p>

                <h3>Load Balancing</h3>

                <p>When many single-phase loads are connected, they need to be distributed appropriately across the available phases. Significant imbalance can place additional stress on parts of the electrical system and reduce the effective use of available capacity.</p>

                <p>Some industrial mining equipment can connect directly to three-phase systems when its electrical specifications support such a configuration.</p>

                <h3>Use in Mining Infrastructure</h3>

                <ul>
                    <li>powering large groups of ASIC miners;</li>
                    <li>distributing electrical load across phases;</li>
                    <li>supplying high-power auxiliary systems;</li>
                    <li>organizing industrial distribution panels.</li>
                </ul>

                <p>The exact connection method must match the equipment specifications and applicable electrical requirements. Three-phase power is one part of the overall electrical infrastructure and is not itself a source of additional energy capacity.</p>'
            ],

            'remote-management' => [
                'title' => 'What Is Remote Management | TM Wiki',
                'description' => 'Remote management allows mining hardware and infrastructure to be monitored and controlled over a network without physical access.',
                'name' => 'Remote Management',
                'caption' => 'Remote monitoring, configuration, and control of mining hardware and infrastructure.',
                'definition' => '<p><strong>Remote Management</strong> is a system of tools and procedures used to monitor, configure, and control mining hardware and related infrastructure through a network connection.</p>

                <p>For large mining sites, remote management allows operators to control many devices from a centralized interface. Depending on the available systems, an operator can monitor equipment status, identify offline devices, change operating parameters, and restart individual miners without physically accessing them.</p>

                <h3>What Can Be Monitored</h3>

                <ul>
                    <li>current <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>;</li>
                    <li>temperature and device status;</li>
                    <li>power consumption when supported by the monitoring system;</li>
                    <li>network connection status;</li>
                    <li>hardware errors;</li>
                    <li>frequency and performance settings;</li>
                    <li>device restart and recovery status.</li>
                </ul>

                <h3>How Remote Management Works</h3>

                <p>A miner connects to the local network, allowing a management platform to collect telemetry and expose controls to the operator. Depending on the hardware, management may be provided through a web interface, dedicated software, or a centralized fleet-management platform.</p>

                <p>Large installations can automatically detect offline devices and generate alerts. This reduces the time between a failure and the operator response.</p>

                <h3>Security</h3>

                <p>Remote access must be protected because administrative access to a miner can allow changes to operating parameters and mining destinations. Authentication, access restrictions, secure communication, and network segmentation can be used to reduce unauthorized access risks.</p>

                <h3>Importance for Large Mining Operations</h3>

                <p>Manual management may be practical for a small number of devices but becomes increasingly inefficient as the fleet grows. Remote management is therefore an important part of large <span class="term" data-term="mining-infrastructure/mining-farm">mining farms</span> and remote mining sites.</p>'
            ],
        ],
    ],

    'mining-economics' => [
        'title' => 'Mining Economics Terms',
        'description' => 'Mining economics glossary covering profitability, ROI, CAPEX, OPEX, payback, cost of mining and break-even terms.',
        'name' => 'Mining Economics',
        'caption' => 'Mining economics terms including profitability, mining costs, ROI, CAPEX, OPEX, payback, depreciation and break-even concepts.',
        'terms' => [
            'mining-revenue' => [
                'title' => 'Mining Revenue: What Is It | TM Wiki',
                'description' => 'Mining revenue is the total value generated by cryptocurrency mining before deducting electricity and other operating expenses.',
                'name' => 'Mining Revenue',
                'caption' => 'The total value generated by mining before applicable expenses are deducted.',
                'definition' => '<p><strong>Mining revenue</strong> is the total value of proceeds generated by cryptocurrency mining before deducting expenses. In a simple model, it is determined by the amount of cryptocurrency mined and its value in the selected currency.</p>

                <p>Revenue may include block rewards received directly or amounts distributed through a <span class="term" data-term="mining-pools/mining-pool">mining pool</span>. The calculation normally uses the amount generated during a specified period and a defined valuation method.</p>

                <h3>Revenue and income</h3>

                <p>The terms income and revenue are sometimes used interchangeably in mining materials. For economic analysis, however, it can be useful to define revenue as gross proceeds and income as a broader or differently adjusted measure.</p>

                <p>After revenue is calculated, it can be compared with <span class="term" data-term="mining-economics/mining-expenses">mining expenses</span> to determine gross profit, net profit, or another defined financial result.</p>

                <h3>Factors affecting revenue</h3>

                <ul>
                    <li>mining hashrate and operating time;</li>
                    <li>network difficulty;</li>
                    <li>block reward and emission rules;</li>
                    <li>market price of the mined cryptocurrency;</li>
                    <li>pool fees and payout conditions;</li>
                    <li>equipment downtime.</li>
                </ul>

                <p>Revenue can also be normalized by hashrate using revenue per hash for equipment and operation comparisons.</p>'
            ],

            'mining-expenses' => [
                'title' => 'Mining Expenses: What Are They | TM Wiki',
                'description' => 'Mining expenses include electricity, hosting, maintenance, network services, taxes, and other costs required to operate mining equipment.',
                'name' => 'Mining Expenses',
                'caption' => 'The costs required to operate and maintain a mining operation.',
                'definition' => '<p><strong>Mining expenses</strong> are the costs incurred while operating mining equipment and maintaining a mining operation. They reduce the financial result generated from cryptocurrency mining.</p>

                <p>Common expenses include electricity, hosting, cooling, maintenance, repairs, replacement components, internet connectivity, infrastructure services, labor, insurance, taxes, and administrative costs.</p>

                <h3>Main expense categories</h3>

                <ul>
                    <li><strong>Energy</strong> — electricity consumed by miners and supporting infrastructure.</li>
                    <li><strong>Operations</strong> — maintenance, repairs, and routine technical services.</li>
                    <li><strong>Hosting</strong> — payments for space, power, cooling, and related facility services.</li>
                    <li><strong>Administration</strong> — personnel, communications, accounting, insurance, and similar costs.</li>
                    <li><strong>Taxes</strong> — applicable tax obligations.</li>
                </ul>

                <p>Current operating costs should be distinguished from capital investments. Operating expenses are generally associated with <span class="term" data-term="mining-economics/opex">OPEX</span>, while equipment purchases and infrastructure construction are generally associated with <span class="term" data-term="mining-economics/capex">CAPEX</span>.</p>

                <p>Mining expenses can be analyzed per day, month, year, unit of hashrate, or mined coin.</p>'
            ],

            'mining-cost' => [
                'title' => 'Mining Cost: What Is It | TM Wiki',
                'description' => 'Mining cost represents the expenses required to produce a given amount of cryptocurrency or a unit of mining output.',
                'name' => 'Mining Cost',
                'caption' => 'The costs associated with producing mining output.',
                'definition' => '<p><strong>Mining cost</strong> represents the expenses attributed to producing a defined amount of cryptocurrency or computational mining output. It is used to evaluate the economics of equipment and mining operations.</p>

                <p>The scope of mining cost depends on the methodology. A narrow calculation may include only electricity, while a broader model can include hosting, maintenance, depreciation, labor, taxes, and other operating expenses.</p>

                <h3>Cost per mined coin</h3>

                <p>One common approach is to estimate the amount of money required to mine one unit of a cryptocurrency. Total attributable costs for a period are divided by the amount mined during the same period.</p>

                <p>The resulting value depends on operating expenses, equipment productivity, network difficulty, uptime, and other variables. A change in market price does not directly change the technical cost of producing a coin, but it changes the difference between market value and mining cost.</p>

                <h3>Cost per unit of hashrate</h3>

                <p>Mining operations can also be compared using <span class="term" data-term="mining-economics/cost-per-hash">cost per hash</span>. This normalizes expenses by computational capacity and is useful for comparing operations of different sizes.</p>

                <p>Mining cost is an important input for break-even and <span class="term" data-term="mining-economics/mining-profitability">profitability</span> calculations.</p>'
            ],

            'capex' => [
                'title' => 'CAPEX in Mining: What Is It | TM Wiki',
                'description' => 'CAPEX in mining refers to capital investments in hardware, infrastructure, construction, and other long-term assets.',
                'name' => 'CAPEX',
                'caption' => 'Short for Capital Expenditure, meaning capital investment in long-term assets.',
                'definition' => '<p><strong>CAPEX</strong> is short for <em>Capital Expenditure</em>. In mining, the term describes investments in assets used to create, expand, or modernize a mining operation.</p>

                <p>Typical CAPEX items include ASIC miners, electrical infrastructure, transformers, containers, cooling systems, network equipment, buildings, and other long-term assets.</p>

                <h3>CAPEX versus OPEX</h3>

                <p>The main practical distinction between CAPEX and <span class="term" data-term="mining-economics/opex">OPEX</span> is the nature of the expenditure. CAPEX is associated with acquiring or creating a long-term asset, while OPEX is associated with ongoing operation.</p>

                <p>For example, purchasing a batch of ASIC miners is generally CAPEX, while electricity used to operate them is generally OPEX.</p>

                <p>CAPEX affects the amount of financing required, the payback period, cash flow, and the overall investment structure of a mining project.</p>'
            ],

            'opex' => [
                'title' => 'OPEX in Mining: What Is It | TM Wiki',
                'description' => 'OPEX in mining means recurring operating expenses such as electricity, hosting, maintenance, and facility costs.',
                'name' => 'OPEX',
                'caption' => 'Short for Operating Expenditure, meaning recurring operating expenses.',
                'definition' => '<p><strong>OPEX</strong> is short for <em>Operating Expenditure</em>. In mining, it refers to costs incurred during the regular operation of mining equipment and infrastructure.</p>

                <p>Typical OPEX components include electricity, <span class="term" data-term="mining-infrastructure/mining-hosting">mining hosting</span>, maintenance, repairs, internet services, personnel, cooling, and other recurring operating expenses.</p>

                <h3>Why OPEX matters</h3>

                <p>OPEX is directly related to the current profitability of a mining operation. Even when mining equipment has already been fully paid for, high electricity or maintenance costs can make continued operation economically unattractive under a particular set of assumptions.</p>

                <p>OPEX is commonly compared with <span class="term" data-term="mining-economics/mining-revenue">revenue</span> to determine an operating result. Long-term project analysis may additionally include capital expenditure and depreciation.</p>

                <p>The exact composition of OPEX depends on the business model and accounting methodology.</p>'
            ],

            'return-on-investment' => [
                'title' => 'Mining ROI: Return on Investment | TM Wiki',
                'description' => 'ROI measures financial return relative to invested capital and is used to evaluate the economic result of a mining investment.',
                'name' => 'Return on Investment',
                'caption' => 'A measure of financial return relative to the capital invested.',
                'definition' => '<p><strong>Return on investment</strong>, commonly abbreviated as ROI, is a metric that compares a financial result with the amount of capital invested. In mining, it can be used to evaluate investments in hardware, infrastructure, or an entire mining project.</p>

                <p>In a simple model, ROI is calculated by dividing the financial return for a defined period by the initial investment and multiplying the result by 100 percent. The exact formula depends on the selected period and definition of return.</p>

                <h3>ROI in mining</h3>

                <p>Mining investment may include ASIC miners, electrical infrastructure, cooling systems, facility construction, and other <span class="term" data-term="mining-economics/capex">CAPEX</span>.</p>

                <p>The result depends on cryptocurrency price, network difficulty, electricity cost, downtime, operating expenses, and the residual value of equipment.</p>

                <p>ROI should not be confused with payback period: ROI expresses a relative financial return, while payback period measures the time required to recover the initial investment.</p>'
            ],

            'depreciation' => [
                'title' => 'Depreciation in Mining: What Is It | TM Wiki',
                'description' => 'Depreciation allocates the cost of a long-term asset across the periods in which the asset is used.',
                'name' => 'Depreciation',
                'caption' => 'The allocation of a long-term asset cost over its useful period.',
                'definition' => '<p><strong>Depreciation</strong> is the allocation of the cost of a long-term asset across the periods in which the asset is used. In mining economics, it helps reflect the fact that equipment has a limited useful life and may lose economic value over time.</p>

                <p>Depreciation does not necessarily represent a cash payment at the moment it is recorded. This distinguishes it from direct cash expenses such as electricity payments.</p>

                <h3>Depreciation in mining models</h3>

                <p>The cost of equipment can be allocated over an estimated useful life. The resulting amount depends on the original cost, useful life, residual value, and depreciation method.</p>

                <p>For mining equipment, economic useful life may be shorter than physical operating life because newer generations can provide substantially better efficiency and network conditions can change.</p>

                <p>Depreciation is closely related to <span class="term" data-term="mining-economics/equipment-depreciation">equipment depreciation</span>, while the broader term can also apply to other long-term infrastructure assets.</p>'
            ],

            'equipment-depreciation' => [
                'title' => 'Mining Equipment Depreciation | TM Wiki',
                'description' => 'Equipment depreciation reflects the gradual allocation of the cost of miners and other long-term mining equipment.',
                'name' => 'Equipment Depreciation',
                'caption' => 'Allocation of mining equipment cost over its useful operating period.',
                'definition' => '<p><strong>Equipment depreciation</strong> is the allocation of the cost of mining equipment and other long-term technical assets across their useful operating periods.</p>

                <p>The concept is particularly relevant to mining because hardware can lose economic value quickly. A newer miner may have substantially better power efficiency, reducing the market and economic value of an older device even when that device remains technically operational.</p>

                <h3>Factors affecting equipment depreciation</h3>

                <ul>
                    <li>original equipment cost;</li>
                    <li>expected useful life;</li>
                    <li>residual value;</li>
                    <li>depreciation method;</li>
                    <li>economic obsolescence.</li>
                </ul>

                <p>Economic obsolescence is especially important for ASIC miners. A device may continue operating, but high electricity costs can make it less economically viable than newer and more efficient hardware.</p>

                <p>Equipment depreciation can be included in <span class="term" data-term="mining-economics/mining-cost">mining cost</span> and long-term profitability models. The accounting and tax treatment depends on the applicable jurisdiction.</p>'
            ],

            'mining-profitability' => [
                'title' => 'Mining Profitability: What Is It | TM Wiki',
                'description' => 'Mining profitability measures the economic efficiency of cryptocurrency mining after considering revenue, operating costs, and operating conditions.',
                'name' => 'Mining Profitability',
                'caption' => 'A measure of the economic efficiency of a mining operation.',
                'definition' => '<p><strong>Mining profitability</strong> is an assessment of the economic efficiency of cryptocurrency mining after considering revenue and the costs associated with operating the equipment.</p>

                <p>Unlike a simple income calculation, profitability analysis requires expenses to be included. Important variables include electricity price, power consumption, hashrate, power efficiency, hosting, maintenance, pool fees, downtime, and current network conditions.</p>

                <h3>Factors affecting profitability</h3>

                <ul>
                    <li>market price of the mined cryptocurrency;</li>
                    <li>network difficulty and reward distribution;</li>
                    <li>equipment hashrate;</li>
                    <li>power consumption and efficiency;</li>
                    <li>electricity tariff;</li>
                    <li>uptime and downtime;</li>
                    <li>pool fees and operating expenses.</li>
                </ul>

                <p>Profitability can be calculated per day, month, year, or another period. Long-term investment analysis should also consider <span class="term" data-term="mining-economics/capex">CAPEX</span>, depreciation, and cash flow.</p>

                <p>A positive operating result does not by itself determine the overall return of a project because initial investment, equipment depreciation, network changes, and market prices can materially affect the long-term result.</p>'
            ],

            'cost-per-hash' => [
                'title' => 'Cost per Hash in Mining | TM Wiki',
                'description' => 'Cost per hash shows the mining expenses attributable to a unit of computational power during a selected period.',
                'name' => 'Cost per Hash',
                'caption' => 'Mining cost normalized by a unit of computational power.',
                'definition' => '<p><strong>Cost per hash</strong> is a metric that relates mining expenses to computational capacity. It allows mining operations of different sizes to be compared on a normalized basis.</p>

                <p>The metric can be expressed as the cost of operating one TH/s, GH/s, or another unit of hashrate for an hour, day, or other period.</p>

                <h3>What can be included</h3>

                <p>Depending on the methodology, the calculation may include only variable costs such as electricity or a broader set of operating expenses. The cost components and calculation period should therefore always be specified when comparing values.</p>

                <p>Cost per hash is particularly useful when compared with revenue per hash. If normalized revenue exceeds the attributable cost under the same assumptions, the operation produces a positive difference for that model.</p>

                <p>Electricity price, <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, power efficiency, and equipment utilization are major inputs into the calculation.</p>'
            ],

            'mining-tax' => [
                'title' => 'Mining Tax: What Is It | TM Wiki',
                'description' => 'Mining tax is a general term for tax obligations associated with cryptocurrency mining, asset sales, or mining business activity.',
                'name' => 'Mining Tax',
                'caption' => 'Tax obligations associated with mining and the receipt or disposal of crypto assets.',
                'definition' => '<p><strong>Mining tax</strong> is a general term for tax obligations that may arise from cryptocurrency mining, the sale of mined assets, business activity, or ownership and disposal of crypto assets.</p>

                <p>The applicable tax treatment depends substantially on the jurisdiction, taxpayer status, legal structure, nature of the activity, and applicable tax rules. There is therefore no universal mining tax rate that applies to all miners.</p>

                <h3>What may be taxable</h3>

                <p>Depending on local law, a tax obligation may arise when cryptocurrency is received through mining, when mined assets are subsequently sold or exchanged, or at the level of a company operating a mining business.</p>

                <p>When modeling the tax burden, it is important to identify the applicable <span class="term" data-term="mining-economics/tax-base">tax base</span>, <span class="term" data-term="mining-economics/tax-rate">tax rate</span>, and available <span class="term" data-term="mining-economics/tax-deduction">tax deductions</span>.</p>

                <p>Taxes can materially affect net profit and cash flow. Specific tax treatment should be determined according to the rules applicable to the relevant jurisdiction.</p>'
            ],

            'tax-deduction' => [
                'title' => 'Tax Deduction in Mining | TM Wiki',
                'description' => 'A tax deduction reduces taxable income or tax liability where such treatment is permitted by the applicable tax rules.',
                'name' => 'Tax Deduction',
                'caption' => 'A legally permitted reduction of taxable income or tax liability.',
                'definition' => '<p><strong>Tax deduction</strong> is a reduction of taxable income or tax liability that is permitted under applicable tax law. The mechanism and eligibility requirements depend on the specific tax system.</p>

                <p>In mining, deductions may matter when calculating the tax obligations of a business, provided that the relevant jurisdiction allows particular expenses, investments, or other items to reduce the applicable tax base or liability.</p>

                <h3>Deduction versus expense</h3>

                <p>A tax deduction should not automatically be treated as an ordinary mining expense. An expense affects the economic result, while a deduction affects the tax calculation according to specific legal rules.</p>

                <p>Some jurisdictions use related concepts such as tax credits, exemptions, allowances, or reductions of taxable income. These mechanisms can have different eligibility requirements and economic effects.</p>

                <p>Mining financial models should consider the applicable <span class="term" data-term="mining-economics/tax-base">tax base</span>, <span class="term" data-term="mining-economics/tax-rate">tax rate</span>, and local tax rules.</p>'
            ],

            'tax-base' => [
                'title' => 'Mining Tax Base: What Is It | TM Wiki',
                'description' => 'The tax base is the amount or measure to which a tax rate is applied to determine the tax liability.',
                'name' => 'Tax Base',
                'caption' => 'The amount or measure used as the basis for calculating a tax.',
                'definition' => '<p><strong>Tax base</strong> is the amount, value, or other measure to which a <span class="term" data-term="mining-economics/tax-rate">tax rate</span> is applied to calculate a tax liability.</p>

                <p>In mining, the tax base can be defined in different ways depending on local legislation. It may be based on the value of cryptocurrency received through mining, revenue, taxable profit, business income, or another legally specified measure.</p>

                <h3>Why the tax base matters</h3>

                <p>The same nominal tax rate can produce very different tax liabilities when applied to different tax bases. Therefore, knowing the percentage rate alone is not enough to determine the actual tax burden.</p>

                <p>The tax base can be affected by deductible expenses, allowances, exemptions, valuation rules, recognition dates, and the treatment of mined cryptocurrency.</p>

                <p>In a mining economic model, the tax base should be distinguished from ordinary <span class="term" data-term="mining-economics/mining-expenses">mining expenses</span> because tax rules do not necessarily follow the same classification.</p>'
            ],

            'tax-rate' => [
                'title' => 'Mining Tax Rate: What Is It | TM Wiki',
                'description' => 'A tax rate determines the amount of tax applied to a defined tax base and depends on the applicable tax system.',
                'name' => 'Tax Rate',
                'caption' => 'The percentage or other rate applied to a defined tax base.',
                'definition' => '<p><strong>Tax rate</strong> is the percentage, fixed amount, or other rate applied to a relevant <span class="term" data-term="mining-economics/tax-base">tax base</span> to determine a tax liability.</p>

                <p>For mining activity, the applicable rate depends on the jurisdiction, taxpayer status, business structure, and type of tax. A single universal mining tax rate therefore cannot be applied to all mining operations.</p>

                <h3>Nominal and effective tax burden</h3>

                <p>The nominal tax rate does not necessarily equal the effective tax burden. Deductions, exemptions, tax credits, expenses, and rules for determining the tax base can change the final amount payable.</p>

                <p>When modeling mining economics, the tax rate should be applied only to the tax base defined by the relevant legislation.</p>

                <p>Taxes can affect net profit, cash flow, and the calculated payback period of a mining project.</p>'
            ],
        ],
    ],

    'blockchain' => [
        'title' => 'Blockchain and Network Terms',
        'description' => 'Blockchain glossary covering blocks, transactions, nodes, mempool, forks, confirmations, nonce and other terms.',
        'name' => 'Blockchain',
        'caption' => 'Core blockchain and cryptocurrency network terms, including blocks, transactions, nodes, mempool, forks, confirmations and other concepts.',
        'terms' => [
            'blockchain' => [
                'title' => 'What Is Blockchain | TM Wiki',
                'description' => 'Blockchain is a distributed ledger where data is stored in linked blocks and validated by network participants.',
                'name' => 'Blockchain',
                'caption' => 'A distributed ledger built from a sequence of cryptographically linked blocks.',
                'definition' => '<p><strong>Blockchain</strong> is a distributed data structure in which records are organized into a sequence of linked blocks. Each new <span class="term" data-term="blockchain/block">block</span> contains data and a cryptographic reference to earlier parts of the chain, making unauthorized changes to established history difficult.</p>

                <p>Copies of a blockchain are maintained by multiple independent <span class="term" data-term="blockchain/blockchain-node">network nodes</span>. Nodes receive new data, validate it according to protocol rules, and maintain their own view of the chain. Depending on the network, agreement may rely on computational work, economic stake, or another <span class="term" data-term="blockchain/consensus-mechanism">consensus mechanism</span>.</p>

                <h3>How blockchain works</h3>

                <ol>
                    <li>A user creates a <span class="term" data-term="blockchain/transaction">transaction</span>.</li>
                    <li>Nodes validate and propagate the transaction.</li>
                    <li>Valid transactions may enter the <span class="term" data-term="blockchain/mempool">mempool</span>.</li>
                    <li>A block producer selects transactions and creates a new block.</li>
                    <li>The network applies its <span class="term" data-term="blockchain/consensus">consensus</span> rules to determine the accepted chain.</li>
                </ol>

                <p>Blockchain technology is used for cryptocurrencies, tokens, smart contracts, and other distributed systems. Its performance, transaction capacity, storage requirements, and security properties depend on the specific protocol.</p>'
            ],

            'block' => [
                'title' => 'What Is a Blockchain Block | TM Wiki',
                'description' => 'A block is a structured unit of blockchain data containing transactions and metadata used to build the chain.',
                'name' => 'Block',
                'caption' => 'A blockchain data unit containing transactions and chain metadata.',
                'definition' => '<p><strong>Block</strong> is a structured unit of data added to a <span class="term" data-term="blockchain/blockchain">blockchain</span>. Depending on the protocol, a block contains a set of <span class="term" data-term="blockchain/transaction">transactions</span>, metadata, and fields that allow nodes to verify its position and validity.</p>

                <p>A block normally contains a <span class="term" data-term="blockchain/block-header">block header</span> and the block body. The exact structure varies between protocols.</p>

                <h3>Blocks in the chain</h3>

                <p>Blocks form an ordered sequence in which each block is linked to an earlier block. Its position is described by <span class="term" data-term="blockchain/block-height">block height</span>. The first block is called the <span class="term" data-term="blockchain/genesis-block">genesis block</span>.</p>

                <p>After receiving a block, nodes validate its structure, transactions, and compliance with <span class="term" data-term="blockchain/consensus">consensus</span> rules. Competing blocks may temporarily exist, and the network can later resolve the competition according to protocol rules.</p>'
            ],

            'genesis-block' => [
                'title' => 'What Is the Genesis Block | TM Wiki',
                'description' => 'The genesis block is the first block of a blockchain and serves as the starting point of its chain.',
                'name' => 'Genesis Block',
                'caption' => 'The first block of a blockchain and the starting point of its history.',
                'definition' => '<p><strong>Genesis block</strong> is the first <span class="term" data-term="blockchain/block">block</span> created for a particular blockchain network. It does not reference a normal previous block and serves as the starting point for the chain.</p>

                <p>The genesis block is normally defined by the protocol or its initial software configuration. Its contents and identifier help nodes determine that they are operating on the intended network.</p>

                <h3>Why the genesis block matters</h3>

                <p>Every regular block references an earlier block. The genesis block provides the initial point from which this sequence begins. It therefore forms part of the basic identity of a blockchain.</p>

                <p>Changing the genesis block generally means creating a different chain or incompatible network history rather than simply modifying an existing block.</p>'
            ],

            'block-header' => [
                'title' => 'What Is a Block Header | TM Wiki',
                'description' => 'A block header contains metadata that links a block to the chain and allows nodes to verify protocol-specific properties.',
                'name' => 'Block Header',
                'caption' => 'The metadata portion of a block used for identification and validation.',
                'definition' => '<p><strong>Block header</strong> is the metadata portion of a <span class="term" data-term="blockchain/block">block</span> containing fields required to identify, validate, and connect the block to the <span class="term" data-term="blockchain/blockchain">blockchain</span>.</p>

                <p>The exact fields depend on the protocol. A header may contain the hash of the previous block, a timestamp, a transaction-tree root, consensus parameters, difficulty information, or other protocol-specific values.</p>

                <h3>Linking blocks</h3>

                <p>A cryptographic reference to the previous block is one of the most important fields. Changing an earlier block changes its identifier and breaks the expected links to subsequent blocks.</p>

                <p>In Proof-of-Work networks, header data also participates in the computation used to find a valid block. The header is therefore directly relevant to <span class="term" data-term="mining/mining">mining</span> in PoW systems.</p>'
            ],

            'block-height' => [
                'title' => 'What Is Block Height | TM Wiki',
                'description' => 'Block height identifies the position of a block relative to the genesis block and is used to navigate blockchain history.',
                'name' => 'Block Height',
                'caption' => 'A number identifying the position of a block in the chain.',
                'definition' => '<p><strong>Block height</strong> is a numerical indicator of a block position relative to the beginning of a <span class="term" data-term="blockchain/blockchain">blockchain</span>. In many networks, the genesis block has height 0 and each following block increases the height by one.</p>

                <p>Height is used by nodes, explorers, wallets, and analytical systems to identify blocks and correlate events with a specific point in the chain history.</p>

                <h3>Height and confirmations</h3>

                <p>When a transaction is included in a block, subsequent blocks increase its number of confirmations. Block height itself is not the same as the confirmation count, although the two values are directly related.</p>

                <p>During a <span class="term" data-term="blockchain/chain-reorganization">chain reorganization</span>, a block at a particular height may cease to belong to the currently accepted chain. For this reason, height should be considered together with the current chain state.</p>'
            ],

            'block-time' => [
                'title' => 'What Is Block Time | TM Wiki',
                'description' => 'Block time describes the interval between blocks or, depending on context, the timestamp associated with a block.',
                'name' => 'Block Time',
                'caption' => 'A time-based measure describing block production or a block timestamp.',
                'definition' => '<p><strong>Block time</strong> describes a temporal property of <span class="term" data-term="blockchain/block">block</span> production. Depending on context, it may refer to the average interval between blocks or to the timestamp stored in an individual block.</p>

                <p>Average block time is an important blockchain parameter because it affects how frequently new confirmations become available and how regularly the chain progresses.</p>

                <h3>Target versus actual block time</h3>

                <p>Many networks define a target block interval, but actual intervals vary randomly around that target. In <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span> systems, block discovery depends on the total computational power and protocol difficulty.</p>

                <p>A single block may therefore arrive much earlier or later than expected. Long-term averages provide a more useful view of actual network block production.</p>'
            ],

            'block-size' => [
                'title' => 'What Is Block Size | TM Wiki',
                'description' => 'Block size measures the amount of data contained in a block and affects blockchain throughput and node requirements.',
                'name' => 'Block Size',
                'caption' => 'The amount of data contained in an individual blockchain block.',
                'definition' => '<p><strong>Block size</strong> is the amount of data contained in a particular <span class="term" data-term="blockchain/block">block</span>. Depending on the protocol, it may be measured directly in bytes or controlled through another protocol-specific metric.</p>

                <p>A block contains both user <span class="term" data-term="blockchain/transaction">transactions</span> and metadata required by the protocol. A larger permitted block can potentially contain more transactions during each block interval.</p>

                <h3>Block-size limits</h3>

                <p>Larger blocks require nodes to transmit, validate, and store more data. Block-size limits therefore involve a trade-off between transaction capacity and the hardware and network requirements imposed on participants.</p>

                <p>Some blockchains use a separate <span class="term" data-term="blockchain/block-weight">block weight</span> metric instead of relying only on raw byte size.</p>'
            ],

            'block-weight' => [
                'title' => 'What Is Block Weight | TM Wiki',
                'description' => 'Block weight is a protocol metric used by some blockchains to measure block capacity under specific data-weighting rules.',
                'name' => 'Block Weight',
                'caption' => 'A protocol-specific metric used to determine the effective size of a block.',
                'definition' => '<p><strong>Block weight</strong> is a protocol-specific metric used to determine how much data a block represents under the rules of the blockchain. The concept is particularly associated with Bitcoin following the introduction of SegWit.</p>

                <p>Different parts of a transaction can receive different weighting under the protocol rules. This allows witness data and other transaction components to contribute differently to the block-capacity limit.</p>

                <h3>Weight versus size</h3>

                <p>Block weight and physical block size in bytes are not interchangeable measurements. A block can have a particular byte size while its protocol-defined weight is calculated using separate rules.</p>

                <p>For networks that use block weight, capacity analysis should therefore consider the protocol weight limit rather than relying only on the number of megabytes stored in a block.</p>'
            ],

            'transaction' => [
                'title' => 'What Is a Blockchain Transaction | TM Wiki',
                'description' => 'A transaction is a blockchain operation that changes network state, such as transferring assets or calling a smart contract.',
                'name' => 'Transaction',
                'caption' => 'A signed operation that changes blockchain state according to network rules.',
                'definition' => '<p><strong>Transaction</strong> is a structured operation that requests a change to the state of a <span class="term" data-term="blockchain/blockchain">blockchain</span>. Depending on the network, it can transfer coins, create or move tokens, call a <span class="term" data-term="blockchain/smart-contract">smart contract</span>, or perform another protocol-defined action.</p>

                <p>After creation, a transaction is normally propagated through the network and validated by nodes. In UTXO-based systems it contains <span class="term" data-term="blockchain/transaction-input">inputs</span> and <span class="term" data-term="blockchain/transaction-output">outputs</span>. Account-based systems use a different structure, commonly involving an account address, nonce, value, and execution data.</p>

                <h3>Transaction lifecycle</h3>

                <ol>
                    <li>The transaction is created and signed.</li>
                    <li>It is broadcast to the network.</li>
                    <li>Nodes validate it.</li>
                    <li>It waits for inclusion in a block.</li>
                    <li>The transaction receives confirmations after block inclusion.</li>
                </ol>

                <p>A <span class="term" data-term="blockchain/transaction-fee">transaction fee</span> may be required. Its calculation and distribution depend on the blockchain protocol.</p>'
            ],

            'transaction-input' => [
                'title' => 'What Is a Transaction Input | TM Wiki',
                'description' => 'A transaction input identifies a source of funds used by a transaction in a UTXO-based blockchain.',
                'name' => 'Transaction Input',
                'caption' => 'A reference to a previous unspent output used by a new transaction.',
                'definition' => '<p><strong>Transaction input</strong> is an element of a transaction in a UTXO-based blockchain that identifies previously created funds being spent by the new transaction.</p>

                <p>An input normally references a specific <span class="term" data-term="blockchain/transaction-output">output of an earlier transaction</span> and includes the data required to prove that the funds can be spent. In Bitcoin-like systems, this can include a digital signature and other unlocking data.</p>

                <h3>Inputs and outputs</h3>

                <p>A transaction can contain multiple inputs. Their combined value provides the funds used to create new outputs and cover the <span class="term" data-term="blockchain/transaction-fee">transaction fee</span>.</p>

                <p>This structure makes it possible to trace individual UTXOs through the chain. Account-based blockchains use a different accounting model and therefore do not use transaction inputs in the same way.</p>'
            ],

            'transaction-output' => [
                'title' => 'What Is a Transaction Output | TM Wiki',
                'description' => 'A transaction output specifies an amount and spending conditions for funds created by a transaction.',
                'name' => 'Transaction Output',
                'caption' => 'A UTXO transaction element that creates funds for future spending.',
                'definition' => '<p><strong>Transaction output</strong> is an element of a transaction in a UTXO-based blockchain that defines an amount of funds and the conditions required to spend them later.</p>

                <p>In Bitcoin-like systems, an output generally contains a value and a locking script or spending condition. Once the transaction is included in a <span class="term" data-term="blockchain/block">block</span>, the output becomes part of the set of unspent funds until it is referenced by a future <span class="term" data-term="blockchain/transaction-input">transaction input</span>.</p>

                <h3>Change outputs</h3>

                <p>If the value of the inputs exceeds the amount being sent, a transaction commonly creates a separate change output controlled by the sender. A single transaction can therefore create outputs for both the recipient and the sender.</p>

                <p>In the UTXO model, the difference between total input value and total output value generally represents the transaction fee.</p>'
            ],

            'transaction-fee' => [
                'title' => 'What Is a Transaction Fee | TM Wiki',
                'description' => 'A transaction fee is a cost associated with processing an operation and including it in a blockchain block.',
                'name' => 'Transaction Fee',
                'caption' => 'A fee associated with processing and including a transaction in the blockchain.',
                'definition' => '<p><strong>Transaction fee</strong> is an amount associated with processing a transaction and including it in a <span class="term" data-term="blockchain/block">block</span>. The exact fee mechanism depends on the blockchain.</p>

                <p>In some networks, the fee depends strongly on the amount of transaction data rather than the value being transferred. This is particularly visible in UTXO systems, where transactions with many inputs can require more block space.</p>

                <h3>Why fees change</h3>

                <p>When block capacity is limited, users compete for inclusion in available blocks. Higher demand can increase the fees required for faster confirmation. Some protocols use explicit fee markets or priority mechanisms to determine which transactions block producers select.</p>

                <p>A transaction fee is distinct from mining electricity costs or other operational expenses. It is an economic mechanism of the blockchain itself and may be distributed among network participants according to protocol rules.</p>'
            ],

            'mempool' => [
                'title' => 'What Is a Mempool | TM Wiki',
                'description' => 'A mempool is a set of unconfirmed transactions accepted by a node but not yet included in a block.',
                'name' => 'Mempool',
                'caption' => 'A collection of pending transactions waiting for block inclusion.',
                'definition' => '<p><strong>Mempool</strong> is a collection of unconfirmed <span class="term" data-term="blockchain/transaction">transactions</span> that a particular node has accepted after validation but that have not yet been included in a confirmed <span class="term" data-term="blockchain/block">block</span>.</p>

                <p>A mempool is not necessarily one global queue shared identically by the entire network. Each node can maintain its own transaction set and apply its own implementation-specific policies for admission, prioritization, and expiration.</p>

                <h3>Role of the mempool</h3>

                <p>When a user broadcasts a transaction, it can propagate between nodes and enter their mempools. A block producer then selects eligible transactions from the available set.</p>

                <p>During periods of high demand, mempools can grow substantially. This can increase competition for limited block space and result in higher <span class="term" data-term="blockchain/transaction-fee">transaction fees</span>.</p>'
            ],

            'chain' => [
                'title' => 'What Is a Blockchain Chain | TM Wiki',
                'description' => 'A blockchain chain is a sequence of linked blocks that represents the historical state of a blockchain network.',
                'name' => 'Chain',
                'caption' => 'A sequence of linked blocks forming the history of a blockchain.',
                'definition' => '<p><strong>Chain</strong> is the ordered sequence of linked <span class="term" data-term="blockchain/block">blocks</span> that forms the history of a <span class="term" data-term="blockchain/blockchain">blockchain</span>.</p>

                <p>Each new block normally contains a cryptographic reference to an earlier block. This creates a sequential structure in which modifying historical data changes the corresponding identifiers and breaks the expected links to later blocks.</p>

                <h3>Main and competing chains</h3>

                <p>Different nodes can temporarily observe different continuations of the same history. This can happen when competing blocks are produced or when protocol rules change. The network <span class="term" data-term="blockchain/consensus">consensus</span> rules determine which continuation is accepted.</p>

                <p>If the network switches from one history to another, a <span class="term" data-term="blockchain/chain-reorganization">chain reorganization</span> occurs. Blocks removed from the active chain may no longer be part of the current accepted history.</p>'
            ],

            'fork' => [
                'title' => 'What Is a Blockchain Fork | TM Wiki',
                'description' => 'A fork is a change to blockchain rules or a divergence between competing versions of chain history.',
                'name' => 'Fork',
                'caption' => 'A protocol-rule change or divergence between blockchain histories.',
                'definition' => '<p><strong>Fork</strong> describes a situation where blockchain protocol rules change or different participants temporarily or permanently follow incompatible rules for building the chain.</p>

                <p>Forks can result from software upgrades, protocol changes, or temporary chain divergence. Depending on compatibility between old and new rules, forks are commonly described as <span class="term" data-term="blockchain/soft-fork">soft forks</span> or <span class="term" data-term="blockchain/hard-fork">hard forks</span>.</p>

                <h3>Why forks occur</h3>

                <ul>
                    <li>protocol upgrades;</li>
                    <li>changes to transaction or block formats;</li>
                    <li>technical fixes;</li>
                    <li>changes to network parameters;</li>
                    <li>disagreements over protocol rules.</li>
                </ul>

                <p>Not every fork creates two permanent blockchains. Temporary competing blocks can be resolved by the network consensus rules without producing a lasting split.</p>'
            ],

            'soft-fork' => [
                'title' => 'What Is a Soft Fork | TM Wiki',
                'description' => 'A soft fork changes blockchain rules by introducing stricter validity conditions while preserving a defined form of compatibility.',
                'name' => 'Soft Fork',
                'caption' => 'A blockchain rule change that introduces stricter validity requirements.',
                'definition' => '<p><strong>Soft fork</strong> is a change to <span class="term" data-term="blockchain/blockchain">blockchain protocol</span> rules that makes the set of valid blocks or transactions more restricted.</p>

                <p>A typical property of a soft fork is that blocks satisfying the new, stricter rules can remain acceptable under the older rule set, although nodes running older software may not independently enforce the new restrictions.</p>

                <h3>Activation</h3>

                <p>The activation method depends on the protocol. It can involve signaling by network participants, a specific block height, a time-based condition, or another defined mechanism.</p>

                <p>A soft fork does not mean that chain divergence is impossible. If participants enforce different rules, the resulting behavior depends on the compatibility properties and consensus design of the particular network.</p>'
            ],

            'hard-fork' => [
                'title' => 'What Is a Hard Fork | TM Wiki',
                'description' => 'A hard fork changes blockchain rules in a way that is incompatible with the old rules for nodes that do not upgrade.',
                'name' => 'Hard Fork',
                'caption' => 'A protocol change that introduces rules incompatible with the previous rule set.',
                'definition' => '<p><strong>Hard fork</strong> is a change to <span class="term" data-term="blockchain/blockchain">blockchain</span> rules in which blocks or transactions valid under the new rules may be invalid under the old rules.</p>

                <p>If some participants upgrade while others continue using the old software, the network can split into incompatible histories. In other cases, participants coordinate the upgrade and the old rules cease to be used without producing a long-term split.</p>

                <h3>What a hard fork can change</h3>

                <p>A hard fork can modify block formats, transaction rules, consensus parameters, or other fundamental protocol properties. If both versions continue operating independently, they form separate networks from the point of divergence.</p>

                <p>The term therefore describes technical rule incompatibility. It does not by itself mean that a new cryptocurrency must be created.</p>'
            ],

            'orphan-block' => [
                'title' => 'What Is an Orphan Block | TM Wiki',
                'description' => 'An orphan block is a block that is no longer part of the currently accepted blockchain history.',
                'name' => 'Orphan Block',
                'caption' => 'A block that has been excluded from the currently accepted chain.',
                'definition' => '<p><strong>Orphan block</strong> is a term used for a block that does not belong to the currently accepted blockchain chain. The exact use of the term varies between protocols and implementations.</p>

                <p>A typical situation occurs when multiple blocks compete for the same position in the chain. After the competition is resolved by the <span class="term" data-term="blockchain/consensus">consensus</span> rules, one continuation is accepted and an alternative block may no longer belong to the active history.</p>

                <p>Technical documentation may distinguish an orphan block from a <span class="term" data-term="blockchain/stale-block">stale block</span>, while some discussions use the terms more loosely. The exact meaning should therefore be interpreted according to the relevant protocol.</p>'
            ],

            'stale-block' => [
                'title' => 'What Is a Stale Block | TM Wiki',
                'description' => 'A stale block is a valid competing block that is not included in the currently selected main chain.',
                'name' => 'Stale Block',
                'caption' => 'A valid competing block that remains outside the current main chain.',
                'definition' => '<p><strong>Stale block</strong> is a block that may be technically valid but is not part of the currently selected chain. In Proof-of-Work systems, this can occur when two miners find valid blocks at nearly the same time.</p>

                <p>Some nodes may initially receive one block while others receive the competing block. As additional blocks are found, the network consensus rules determine which branch becomes the accepted continuation.</p>

                <h3>Mining implications</h3>

                <p>For a <span class="term" data-term="mining/miner">miner</span>, a stale block means that the discovered block did not become part of the current main chain. Depending on the protocol and reward mechanism, the associated block reward may therefore not be realized.</p>

                <p>Stale-block frequency can be affected by network propagation time, topology, block production rate, and implementation details.</p>'
            ],

            'chain-reorganization' => [
                'title' => 'What Is a Chain Reorganization | TM Wiki',
                'description' => 'A chain reorganization replaces part of the current blockchain history with another valid sequence of blocks.',
                'name' => 'Chain Reorganization',
                'caption' => 'A replacement of part of the current chain with an alternative accepted history.',
                'definition' => '<p><strong>Chain reorganization</strong> is a change to the currently accepted history of a <span class="term" data-term="blockchain/blockchain">blockchain</span> in which one or more previously selected blocks are replaced by an alternative sequence.</p>

                <p>Reorganizations can occur when different network participants temporarily build competing branches from the same common ancestor. Once additional information becomes available, nodes apply <span class="term" data-term="blockchain/consensus">consensus</span> rules and may switch to another branch.</p>

                <h3>Consequences</h3>

                <p>Transactions included in replaced blocks may become unconfirmed again and return to the <span class="term" data-term="blockchain/mempool">mempool</span> if they are not present in the new chain. Some transactions can also become invalid because the new history changes the state or ordering of events.</p>

                <p>Small reorganizations can be a normal technical property of some networks. Deeper reorganizations can have greater implications for transaction finality and blockchain security.</p>'
            ],

            'blockchain-node' => [
                'title' => 'What Is a Blockchain Node | TM Wiki',
                'description' => 'A blockchain node is a computer or software instance that participates in validating, storing, or transmitting network data.',
                'name' => 'Blockchain Node',
                'caption' => 'A network participant that performs blockchain data, validation, or communication functions.',
                'definition' => '<p><strong>Blockchain node</strong> is a computer or software instance connected to a blockchain network and performing one or more functions defined by the protocol or implementation.</p>

                <p>Depending on its type, a node may store the blockchain history, validate transactions and blocks, relay data to other participants, or maintain only a limited representation of network information.</p>

                <h3>Common node functions</h3>

                <ul>
                    <li>receiving and validating transactions;</li>
                    <li>receiving and validating blocks;</li>
                    <li>relaying network data;</li>
                    <li>storing blockchain state or history;</li>
                    <li>participating in consensus when the protocol requires it.</li>
                </ul>

                <p>Common node types include <span class="term" data-term="blockchain/full-node">full nodes</span> and <span class="term" data-term="blockchain/light-node">light nodes</span>. Their storage, CPU, memory, and networking requirements can differ significantly.</p>'
            ],

            'full-node' => [
                'title' => 'What Is a Full Node | TM Wiki',
                'description' => 'A full node independently verifies blockchain blocks and transactions according to the rules of the protocol.',
                'name' => 'Full Node',
                'caption' => 'A node capable of independently validating blockchain data against protocol rules.',
                'definition' => '<p><strong>Full node</strong> is a type of <span class="term" data-term="blockchain/blockchain-node">blockchain node</span> that independently validates blocks and transactions according to the rules of the relevant protocol.</p>

                <p>A full node normally stores substantial blockchain data and maintains enough state to validate new transactions and blocks. Some implementations also support archival modes that preserve additional historical information.</p>

                <h3>Why full nodes are used</h3>

                <p>Independent validation reduces reliance on external servers when determining which transactions and blocks are valid. A full node can reject data that violates protocol rules even if another participant claims that the data is correct.</p>

                <p>Requirements vary by blockchain and can include substantial disk space, fast storage, memory, CPU resources, synchronization time, and network bandwidth.</p>'
            ],

            'light-node' => [
                'title' => 'What Is a Light Node | TM Wiki',
                'description' => 'A light node uses fewer local resources and may obtain part of the blockchain data from full nodes.',
                'name' => 'Light Node',
                'caption' => 'A node designed to operate with reduced storage and processing requirements.',
                'definition' => '<p><strong>Light node</strong> is a type of <span class="term" data-term="blockchain/blockchain-node">blockchain node</span> designed to operate without storing and processing the full blockchain history locally.</p>

                <p>Depending on the protocol, a light node may store block headers, use inclusion proofs, or request additional information from full nodes. SPV is a well-known example of a lightweight verification approach in Bitcoin-like systems.</p>

                <h3>Advantages and limitations</h3>

                <p>The main advantage is lower demand for disk storage, computing resources, and synchronization. This makes lightweight designs suitable for mobile devices and resource-constrained environments.</p>

                <p>The trade-off is that the node may perform less independent validation than a full node. Its security properties depend on the specific protocol, implementation, proof system, and interaction with other network participants.</p>'
            ],

            'consensus' => [
                'title' => 'What Is Blockchain Consensus | TM Wiki',
                'description' => 'Consensus is the process through which blockchain participants agree on valid state and accepted chain history.',
                'name' => 'Consensus',
                'caption' => 'The process of reaching agreement on valid blockchain state and history.',
                'definition' => '<p><strong>Consensus</strong> is the process through which distributed participants in a blockchain network reach agreement about valid state and the accepted sequence of blocks.</p>

                <p>Without a consensus process, independent nodes could maintain permanently different versions of the blockchain history. Consensus rules determine which blocks are valid, how competing branches are resolved, and how new state changes are accepted.</p>

                <h3>Consensus and protocol rules</h3>

                <p>The consensus process is part of a broader protocol design. In Proof-of-Work systems, participants use computational work as part of the security model. In Proof-of-Stake systems, block production and validation are connected to staking and economic incentives.</p>

                <p>Consensus does not necessarily mean that every node literally votes on every block. The exact process is determined by the network <span class="term" data-term="blockchain/consensus-mechanism">consensus mechanism</span>.</p>'
            ],

            'consensus-mechanism' => [
                'title' => 'What Is a Consensus Mechanism | TM Wiki',
                'description' => 'A consensus mechanism defines how a blockchain selects blocks and coordinates the state of its distributed network.',
                'name' => 'Consensus Mechanism',
                'caption' => 'A set of rules defining how a network selects and validates blocks.',
                'definition' => '<p><strong>Consensus mechanism</strong> is the set of technical rules that determines how participants in a distributed network agree on the valid <span class="term" data-term="blockchain/chain">chain</span> and blockchain state.</p>

                <p>It defines questions such as who can propose blocks, how other participants validate them, which chain is accepted, and what economic or computational conditions protect the network from invalid history.</p>

                <h3>Examples</h3>

                <ul>
                    <li><strong>Proof-of-Work</strong> — security is linked to computational work.</li>
                    <li><strong>Proof-of-Stake</strong> — participation in block validation is linked to staking and economic security.</li>
                    <li>Other mechanisms can use different rules for block production, validation, and participant incentives.</li>
                </ul>

                <p>The consensus mechanism affects hardware requirements, confirmation behavior, energy use, participation economics, and the security model of a blockchain. Therefore, the same terminology can describe technically different systems across networks.</p>'
            ],

            'smart-contract' => [
                'title' => 'What Is a Smart Contract | TM Wiki',
                'description' => 'A smart contract is blockchain-based program logic that executes predefined operations when specified conditions are met.',
                'name' => 'Smart Contract',
                'caption' => 'A blockchain program that executes predefined logic and manages on-chain state.',
                'definition' => '<p><strong>Smart contract</strong> is a program deployed on a blockchain or its execution environment that performs predefined logic when it receives appropriate inputs.</p>

                <p>Instead of relying on a single centralized server, execution follows the rules of the blockchain network. The resulting state changes can become part of the distributed ledger and be independently verified by network participants.</p>

                <h3>What smart contracts can do</h3>

                <ul>
                    <li>transfer or lock digital assets;</li>
                    <li>issue and manage tokens;</li>
                    <li>enforce conditions for operations;</li>
                    <li>interact with other contracts;</li>
                    <li>implement decentralized application logic.</li>
                </ul>

                <p>Calling a smart contract is commonly performed through a <span class="term" data-term="blockchain/transaction">transaction</span>. Users may pay network resources according to the blockchain fee model. Bugs in contract code can produce unintended results, so important contracts may undergo audits and additional verification.</p>'
            ],
        ],
    ],

    'cryptocurrency' => [
        'title' => 'Cryptocurrency Terms',
        'description' => 'Cryptocurrency glossary covering coins, tokens, stablecoins, supply, market cap, ATH and other crypto terms.',
        'name' => 'Cryptocurrency',
        'caption' => 'Terms related to cryptocurrencies and digital assets, including coins, tokens, stablecoins, supply, market capitalization, ATH and other concepts.',
        'terms' => [
            'cryptocurrency' => [
                'title' => 'What Is a Cryptocurrency | TM Wiki',
                'description' => 'A cryptocurrency is a digital asset secured by cryptography and usually recorded on a blockchain. Learn how cryptocurrencies work.',
                'name' => 'Cryptocurrency',
                'caption' => 'A digital asset based on cryptography and distributed network technology.',
                'definition' => '<p><strong>Cryptocurrency</strong> is a digital asset whose creation, transfer, and accounting are secured by cryptographic methods and the rules of a distributed network. In most modern projects, transaction history is recorded on a <span class="term" data-term="blockchain/blockchain">blockchain</span>, while the validity of new records is determined by a <span class="term" data-term="blockchain/consensus">consensus</span> mechanism.</p>

                <p>Unlike traditional monetary systems, a cryptocurrency generally does not require a single central bank or intermediary to process transfers. Network participants use software that validates transactions and maintains a consistent state of the ledger. Depending on the project, network security may rely on mechanisms such as <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span> or <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span>.</p>

                <h3>How cryptocurrency works</h3>

                <p>When a user sends cryptocurrency, a <span class="term" data-term="blockchain/transaction">transaction</span> is created and authorized with a cryptographic key. The network validates the transaction, after which it may be included in a block and become part of the blockchain history. Depending on the network, the user may also pay a <span class="term" data-term="blockchain/transaction-fee">transaction fee</span>.</p>

                <p>The economic model of a cryptocurrency is defined by rules governing issuance and distribution. These rules may include a fixed maximum supply, scheduled issuance, token burning, rewards for network participants, or other mechanisms.</p>

                <h3>Cryptocurrency, coin, and token</h3>

                <p>The term cryptocurrency is used broadly and can refer to both a <span class="term" data-term="cryptocurrency/coin">coin</span> and certain types of tokens. In more precise terminology, a <span class="term" data-term="cryptocurrency/native-coin">native coin</span> is the native asset of a blockchain, while a token is generally issued using an existing blockchain infrastructure.</p>

                <h3>What determines cryptocurrency value</h3>

                <ul>
                    <li>utility and real-world use cases;</li>
                    <li>network security and resilience;</li>
                    <li>degree of decentralization;</li>
                    <li>liquidity and trading activity;</li>
                    <li>supply and issuance model;</li>
                    <li>economic incentives for network participants;</li>
                    <li>demand from users and market participants.</li>
                </ul>

                <p>The market price of a cryptocurrency is determined by supply and demand and can change substantially. Market capitalization, supply, and price are therefore separate metrics that should be analyzed independently.</p>'
            ],

            'coin' => [
                'title' => 'What Is a Crypto Coin | TM Wiki',
                'description' => 'A crypto coin is the native digital asset of a blockchain. Learn about coins, fees, issuance, network rewards, and tokens.',
                'name' => 'Coin',
                'caption' => 'The native digital asset of its own blockchain network.',
                'definition' => '<p>A <strong>coin</strong> is a digital asset that serves as the native unit of a particular blockchain. A coin exists directly within the protocol of its own network and is commonly used to transfer value, pay transaction fees, and provide economic incentives.</p>

                <p>For example, BTC is the native coin of Bitcoin, while ETH is the native coin of Ethereum. The rules governing these assets are defined by their respective blockchain protocols.</p>

                <h3>Uses of a coin</h3>

                <ul>
                    <li>transferring value between addresses;</li>
                    <li>paying network fees;</li>
                    <li>rewarding miners or validators;</li>
                    <li>participating in the network economy;</li>
                    <li>in some networks, participating in governance or network security.</li>
                </ul>

                <p>In networks using <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, new coins may enter circulation through block rewards. In <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> networks, issuance and distribution may be connected to validators and staking.</p>

                <h3>Coin vs. token</h3>

                <p>The key distinction is how the asset is created. A coin is the native unit of its own blockchain. A <span class="term" data-term="cryptocurrency/token">token</span> is generally created on top of an existing blockchain using its standards and programmable infrastructure.</p>

                <p>The word coin is sometimes used informally for any cryptoasset, but this usage can be technically imprecise.</p>'
            ],

            'token' => [
                'title' => 'What Is a Crypto Token | TM Wiki',
                'description' => 'A token is a digital asset issued using an existing blockchain. Learn about token types, functions, and differences from coins.',
                'name' => 'Token',
                'caption' => 'A digital asset issued using an existing blockchain infrastructure.',
                'definition' => '<p>A <strong>token</strong> is a digital asset issued and accounted for using the infrastructure of an existing blockchain. Unlike a <span class="term" data-term="cryptocurrency/coin">coin</span>, a token is generally not the native unit of its own blockchain.</p>

                <p>Tokens can represent different types of rights, utility, or economic value. They can be used for application access, governance, accounting, representation of other assets, and financial operations.</p>

                <h3>How tokens are created</h3>

                <p>On programmable blockchains, a token is often implemented through a <span class="term" data-term="blockchain/smart-contract">smart contract</span>. The contract can maintain balances and ownership information and define transfer rules and other operations. The exact architecture depends on the blockchain and token standard.</p>

                <h3>Common token types</h3>

                <ul>
                    <li><span class="term" data-term="cryptocurrency/utility-token">utility tokens</span> — provide access to products or functions;</li>
                    <li><span class="term" data-term="cryptocurrency/governance-token">governance tokens</span> — provide mechanisms for protocol governance;</li>
                    <li><span class="term" data-term="cryptocurrency/stablecoin">stablecoins</span> — seek to maintain relatively stable value;</li>
                    <li><span class="term" data-term="cryptocurrency/wrapped-token">wrapped tokens</span> — represent another asset in a compatible blockchain format.</li>
                </ul>

                <p>A single token can serve several functions at the same time. Classification therefore depends on both technical implementation and economic purpose.</p>'
            ],

            'native-coin' => [
                'title' => 'What Is a Native Coin | TM Wiki',
                'description' => 'A native coin is the primary asset of a blockchain, used for fees, value transfer, rewards, and network incentives.',
                'name' => 'Native Coin',
                'caption' => 'The primary asset built directly into a blockchain protocol.',
                'definition' => '<p>A <strong>native coin</strong> is the base digital asset directly built into a particular blockchain protocol. Its accounting and circulation rules are part of the protocol itself rather than a separate token contract or application.</p>

                <p>A native coin commonly serves several functions at once. It can be used to pay <span class="term" data-term="blockchain/transaction-fee">transaction fees</span>, transfer value, and reward participants who provide network resources.</p>

                <h3>Role of a native coin</h3>

                <ul>
                    <li>paying for computational or network resources;</li>
                    <li>incentivizing miners or validators;</li>
                    <li>transferring value between users;</li>
                    <li>participating in network security;</li>
                    <li>in some systems, participating in protocol governance.</li>
                </ul>

                <p>For example, BTC is the native coin of Bitcoin, while ETH is the native coin of Ethereum. Ethereum can also host thousands of tokens that use its infrastructure and ETH for network resources without being the native asset of Ethereum itself.</p>'
            ],

            'altcoin' => [
                'title' => 'What Is an Altcoin | TM Wiki',
                'description' => 'An altcoin is a cryptoasset generally considered an alternative to Bitcoin. Learn what the term means and how altcoins differ.',
                'name' => 'Altcoin',
                'caption' => 'A cryptoasset generally considered an alternative to Bitcoin.',
                'definition' => '<p>An <strong>altcoin</strong> is a general term for cryptoassets considered alternatives to Bitcoin. The name comes from “alternative coin,” but there is no strict technical boundary separating altcoins from other cryptoassets.</p>

                <p>In broad usage, the term can refer to native coins of different blockchains and, in some contexts, other cryptoassets. The exact scope depends on how the term is being used.</p>

                <h3>How altcoins differ</h3>

                <p>Altcoins can differ in consensus mechanism, transaction throughput, issuance model, maximum supply, programmability, fee structure, and intended purpose.</p>

                <p>For example, one project may focus on payments, another on <span class="term" data-term="defi/defi">decentralized finance</span>, and another on smart contracts or specialized computation.</p>

                <p>The term altcoin describes an asset in relation to Bitcoin rather than a specific technical architecture.</p>'
            ],

            'stablecoin' => [
                'title' => 'What Is a Stablecoin | TM Wiki',
                'description' => 'A stablecoin is a cryptoasset designed to maintain relatively stable value. Learn about collateral and stabilization models.',
                'name' => 'Stablecoin',
                'caption' => 'A cryptoasset designed to maintain relatively stable value against a chosen reference.',
                'definition' => '<p>A <strong>stablecoin</strong> is a cryptoasset designed to maintain relatively stable value relative to a chosen reference. The reference is often a fiat currency such as the US dollar, although other models exist.</p>

                <p>Stablecoins are used for payments, liquidity management, trading, and <span class="term" data-term="defi/defi">DeFi</span> applications. They allow users to operate within blockchain infrastructure without continuously converting between volatile cryptoassets and traditional currencies.</p>

                <h3>Main stablecoin models</h3>

                <ul>
                    <li><strong>fiat-backed</strong> — rely on reserves associated with traditional currencies;</li>
                    <li><strong>crypto-backed</strong> — use other cryptoassets as collateral;</li>
                    <li><strong>algorithmic</strong> — use programmed supply and incentive mechanisms.</li>
                </ul>

                <p>Price stability does not mean that a stablecoin is risk-free or guaranteed to maintain an exact fixed price. Its value can depend on reserve quality, liquidity, redemption mechanisms, governance, market conditions, and protocol reliability.</p>

                <h3>Uses</h3>

                <p>Stablecoins are used as trading units on exchanges, for moving capital between networks, and as assets in financial protocols. In DeFi they commonly serve as base assets for lending, swaps, and liquidity provision.</p>'
            ],

            'utility-token' => [
                'title' => 'What Is a Utility Token | TM Wiki',
                'description' => 'A utility token is a digital asset designed to provide access to products, services, or functions within a crypto project.',
                'name' => 'Utility Token',
                'caption' => 'A token primarily designed for use within a product, protocol, or ecosystem.',
                'definition' => '<p>A <strong>utility token</strong> is a token whose primary function is to provide access to particular products, services, or capabilities within an ecosystem.</p>

                <p>Depending on the project, a utility token may be used to pay for services, access application features, pay internal fees, receive discounts, or perform other protocol-specific operations.</p>

                <h3>How utility tokens work</h3>

                <p>The economic role of the token is defined by the rules of the particular system. The existence of a utility token does not automatically mean that holders receive equity, profits, or governance rights in the underlying company or project.</p>

                <p>A utility token can also have a market price and trade on exchanges. Its value may therefore depend not only on practical utility but also on supply, demand, liquidity, and market expectations.</p>

                <p>A single asset can combine utility functions with other functions, such as governance.</p>'
            ],

            'governance-token' => [
                'title' => 'What Is a Governance Token | TM Wiki',
                'description' => 'A governance token enables participation in protocol decisions. Learn about voting, delegation, governance rights, and limitations.',
                'name' => 'Governance Token',
                'caption' => 'A token used to participate in the governance of a protocol or decentralized application.',
                'definition' => '<p>A <strong>governance token</strong> is a token that gives holders defined rights to participate in the governance of a protocol, application, or ecosystem.</p>

                <p>Governance systems may allow holders to vote on protocol parameters, fee structures, treasury spending, smart-contract upgrades, and other proposals. The exact powers depend on the system.</p>

                <h3>Voting</h3>

                <p>In some systems, voting power is related to the number of tokens held. Others use delegation, token locking, or additional mechanisms designed to reduce concentration of control.</p>

                <p>A governance right should not automatically be interpreted as legal ownership. A governance token does not necessarily represent equity in a company or a right to receive its profits.</p>

                <h3>Governance risks</h3>

                <ul>
                    <li>concentration of tokens among a small number of participants;</li>
                    <li>low voter participation;</li>
                    <li>economic influence of large holders;</li>
                    <li>vulnerabilities in voting and proposal-execution mechanisms.</li>
                </ul>

                <p>A governance token is therefore a component of a governance system rather than a universal equivalent of a corporate share.</p>'
            ],

            'wrapped-token' => [
                'title' => 'What Is a Wrapped Token | TM Wiki',
                'description' => 'A wrapped token represents another asset in a different blockchain environment. Learn about backing, issuance, and risks.',
                'name' => 'Wrapped Token',
                'caption' => 'A tokenized representation of another asset in a compatible blockchain environment.',
                'definition' => '<p>A <strong>wrapped token</strong> is a token that represents another asset in a blockchain or token standard where the original asset cannot be used directly.</p>

                <p>A common model involves locking or holding the original asset and issuing a corresponding amount of tokens on another network. When the wrapped tokens are redeemed, they are removed from circulation and the original asset can be released.</p>

                <h3>Why wrapped tokens are used</h3>

                <p>They allow an asset to be used in applications and protocols that cannot directly support its native form. A tokenized representation can, for example, make an asset available to <span class="term" data-term="defi/liquidity-pool">liquidity pools</span>, lending protocols, and other applications.</p>

                <h3>Backing and risks</h3>

                <p>The reliability of a wrapped token depends on the mechanism that links the representation to the original asset. Risks can arise from custodians, smart contracts, bridges, or other infrastructure components.</p>

                <p>A wrapped token should therefore not automatically be assumed to be fully equivalent to the original asset. Its value and redemption mechanism depend on the specific implementation.</p>'
            ],

            'tokenomics' => [
                'title' => 'What Is Tokenomics | TM Wiki',
                'description' => 'Tokenomics describes a cryptoasset economic model, including issuance, supply, distribution, incentives, and token burns.',
                'name' => 'Tokenomics',
                'caption' => 'The economic model governing the issuance, distribution, and use of a cryptoasset.',
                'definition' => '<p><strong>Tokenomics</strong> is the collection of economic rules and parameters governing the creation, distribution, circulation, and use of a cryptoasset.</p>

                <p>Tokenomics describes where an asset supply comes from, who receives it, how quickly new units enter circulation, and what mechanisms can increase or reduce available supply.</p>

                <h3>Key tokenomics parameters</h3>

                <ul>
                    <li><span class="term" data-term="cryptocurrency/total-supply">total supply</span> — total units created;</li>
                    <li><span class="term" data-term="cryptocurrency/max-supply">max supply</span> — maximum supply when one exists;</li>
                    <li><span class="term" data-term="cryptocurrency/circulating-supply">circulating supply</span> — units considered to be in circulation;</li>
                    <li><span class="term" data-term="cryptocurrency/emission">emission</span> — creation of new units;</li>
                    <li><span class="term" data-term="cryptocurrency/token-burn">token burn</span> — removal of units from available supply;</li>
                    <li>allocation among users, teams, investors, and treasuries;</li>
                    <li>vesting and token unlock schedules.</li>
                </ul>

                <h3>Why tokenomics matters</h3>

                <p>The economic model influences potential changes in supply and the incentives of network participants. For example, a large allocation held by a team or early investors can result in future changes to available supply when those tokens become unlocked.</p>

                <p>Tokenomics does not directly determine an asset price. Market value also depends on demand, liquidity, utility, adoption, and broader market conditions.</p>'
            ],

            'total-supply' => [
                'title' => 'What Is Total Supply | TM Wiki',
                'description' => 'Total supply is the total number of existing cryptoasset units under a project’s accounting and supply rules.',
                'name' => 'Total Supply',
                'caption' => 'The total number of cryptoasset units that exist under its defined supply rules.',
                'definition' => '<p><strong>Total supply</strong> is the total number of units of a cryptoasset that exist according to the rules of a particular protocol or token at a given point in time.</p>

                <p>The metric can include units that are not freely circulating, such as locked tokens, tokens held by contracts, or other units that are temporarily unavailable to users. The exact definition depends on the project and the methodology used by the data provider.</p>

                <h3>Total supply vs. circulating supply</h3>

                <p><span class="term" data-term="cryptocurrency/circulating-supply">Circulating supply</span> generally represents the amount considered available to the market. Total supply is broader and can include tokens outside free circulation.</p>

                <p>For example, if a project has created one billion tokens but part of that supply is locked, total supply may be greater than circulating supply.</p>

                <h3>Relationship to tokenomics</h3>

                <p>Total supply can change because of additional issuance or <span class="term" data-term="cryptocurrency/token-burn">token burns</span>. It should therefore be considered together with the asset’s issuance rules.</p>'
            ],

            'max-supply' => [
                'title' => 'What Is Max Supply | TM Wiki',
                'description' => 'Max supply is the maximum number of cryptoasset units allowed by its protocol or economic model.',
                'name' => 'Max Supply',
                'caption' => 'The maximum number of asset units that can exist under defined rules.',
                'definition' => '<p><strong>Max supply</strong> is the maximum number of units of a cryptoasset that can exist according to its protocol or economic model.</p>

                <p>Not every cryptoasset has a fixed maximum supply. Some protocols impose a hard limit, while others allow unlimited or conditionally limited issuance.</p>

                <h3>Max supply and other supply metrics</h3>

                <p><span class="term" data-term="cryptocurrency/circulating-supply">Circulating supply</span> measures the amount in circulation, while <span class="term" data-term="cryptocurrency/total-supply">total supply</span> measures the existing supply according to a defined methodology. Max supply represents a potential upper limit.</p>

                <p>If max supply is 21 million, this means that, while the relevant rules remain in place, the protocol is designed not to create more than that amount. Protocol upgrades or governance mechanisms can affect such rules in some systems.</p>

                <h3>Why max supply matters</h3>

                <p>The supply cap is one of the parameters of an asset’s tokenomics. A low maximum supply by itself does not guarantee a high market value. Economic outcomes also depend on demand, distribution, utility, and liquidity.</p>'
            ],

            'circulating-supply' => [
                'title' => 'What Is Circulating Supply | TM Wiki',
                'description' => 'Circulating supply is the amount of a cryptoasset considered to be in circulation and is used to calculate market capitalization.',
                'name' => 'Circulating Supply',
                'caption' => 'The amount of cryptoasset units considered to be circulating and available to the market.',
                'definition' => '<p><strong>Circulating supply</strong> is an estimate of the number of cryptoasset units considered to be in circulation and available to the market at a particular point in time.</p>

                <p>The metric is commonly used to calculate <span class="term" data-term="cryptocurrency/market-capitalization">market capitalization</span>. In its simplest form, market capitalization equals the asset price multiplied by circulating supply.</p>

                <h3>What may be excluded</h3>

                <p>Depending on the methodology, circulating supply may exclude locked team allocations, reserves, unreleased tokens, certain contract-held assets, or other units that are not considered freely circulating.</p>

                <p>As a result, circulating-supply figures can differ between data providers.</p>

                <h3>Supply changes</h3>

                <p>Circulating supply can increase when new units are issued or previously locked tokens are unlocked. It can decrease through token burns or depending on the accounting methodology.</p>

                <p>It should not be confused with <span class="term" data-term="cryptocurrency/total-supply">total supply</span> or <span class="term" data-term="cryptocurrency/max-supply">max supply</span>.</p>'
            ],

            'emission' => [
                'title' => 'What Is Cryptocurrency Emission | TM Wiki',
                'description' => 'Cryptocurrency emission is the creation of new asset units. Learn about issuance mechanisms, rewards, and supply growth.',
                'name' => 'Emission',
                'caption' => 'The process of creating and issuing new cryptoasset units.',
                'definition' => '<p><strong>Emission</strong> is the process of creating new units of a cryptocurrency or token according to the rules of its protocol or economic model.</p>

                <p>The issuance mechanism depends on the project. In networks using <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, new coins may be created through block rewards. In Proof-of-Stake systems, issuance may be connected to validator rewards.</p>

                <h3>Emission and supply</h3>

                <p>Emission increases the total number of existing units unless it is offset by token burning. Therefore, supply analysis should consider both newly issued units and units removed from circulation.</p>

                <p>Some protocols use predetermined issuance schedules. Others adjust issuance according to network conditions, validator participation, or governance decisions.</p>

                <h3>Emission in mining</h3>

                <p>In mining-based networks, new coins are often issued through the <span class="term" data-term="mining/block-reward">block reward</span>. This can include the <span class="term" data-term="mining/block-subsidy">block subsidy</span> and transaction fees. Fees are generally not new issuance because they represent existing assets transferred from users to block producers.</p>'
            ],

            'inflation' => [
                'title' => 'What Is Crypto Inflation | TM Wiki',
                'description' => 'Crypto inflation refers to growth in asset supply. Learn about issuance, inflation rates, and their role in token economics.',
                'name' => 'Inflation',
                'caption' => 'An increase in the supply of a cryptoasset relative to the existing supply.',
                'definition' => '<p><strong>Crypto inflation</strong>, in the context of tokenomics, generally refers to an increase in an asset’s supply caused by the issuance of new units. A meaningful analysis considers not only the absolute amount issued but also the amount relative to the existing supply.</p>

                <p>A simplified annual inflation rate can be estimated as net supply growth during a period divided by the supply at the beginning of that period. Actual protocol-specific calculations can be more complex.</p>

                <h3>Issuance vs. net inflation</h3>

                <p>New issuance does not necessarily produce the same amount of net supply growth. If a protocol simultaneously performs <span class="term" data-term="cryptocurrency/token-burn">token burns</span>, the final increase in supply can be smaller or even negative.</p>

                <p>It is therefore useful to distinguish gross issuance from net supply change when analyzing tokenomics.</p>

                <h3>Why inflation matters</h3>

                <p>Issuance affects how new units are distributed and can change the relative share of existing holders. Inflation alone does not determine an asset’s price, which also depends on demand, utility, liquidity, and other market factors.</p>'
            ],

            'deflation' => [
                'title' => 'What Is Crypto Deflation | TM Wiki',
                'description' => 'Crypto deflation refers to a reduction in asset supply. Learn about token burns, net issuance, and supply dynamics.',
                'name' => 'Deflation',
                'caption' => 'A reduction in the total supply of a cryptoasset relative to a previous period.',
                'definition' => '<p><strong>Crypto deflation</strong>, in the context of tokenomics, means a reduction in the total supply of an asset. This can occur when the number of units destroyed or removed from circulation exceeds the number of new units issued.</p>

                <p>One common mechanism is <span class="term" data-term="cryptocurrency/token-burn">token burning</span>. The deflationary effect depends on the relationship between issuance and destruction.</p>

                <h3>Net supply change</h3>

                <p>If a protocol issues one million new units and burns 1.2 million units, net supply falls by 200,000 units. Gross issuance still exists, but the final change in supply is negative.</p>

                <p>A deflationary mechanism does not automatically imply a higher market price. Price depends on both supply and demand as well as other market factors.</p>'
            ],

            'token-burn' => [
                'title' => 'What Is a Token Burn | TM Wiki',
                'description' => 'A token burn permanently removes cryptoasset units from available circulation. Learn why tokens are burned and how it affects supply.',
                'name' => 'Token Burn',
                'caption' => 'A mechanism for permanently or conditionally removing tokens from circulation.',
                'definition' => '<p>A <strong>token burn</strong> is a process in which a certain amount of a cryptoasset is removed from available circulation so that the units can no longer be used or are effectively inaccessible.</p>

                <p>Blockchain systems may implement burning through designated addresses or protocol-level mechanisms. In some systems, burning occurs automatically as part of particular operations.</p>

                <h3>Why tokens are burned</h3>

                <ul>
                    <li>to reduce supply;</li>
                    <li>to implement a predefined tokenomics model;</li>
                    <li>to link protocol usage with changes in supply;</li>
                    <li>to remove incorrectly created or excess units.</li>
                </ul>

                <p>For example, a protocol may direct part of its fees into a burn mechanism. In such a model, higher network activity can potentially increase the amount of tokens burned.</p>

                <h3>Burning and price</h3>

                <p>A reduction in supply does not guarantee a higher price. Market price depends on both supply and demand, so the economic effect should be evaluated together with issuance and actual demand for the asset.</p>'
            ],

            'halving' => [
                'title' => 'What Is a Crypto Halving | TM Wiki',
                'description' => 'A halving is a scheduled reduction in block rewards. Learn how halving affects issuance and mining economics.',
                'name' => 'Halving',
                'caption' => 'A scheduled reduction in the block reward in certain blockchain networks.',
                'definition' => '<p>A <strong>halving</strong> is a protocol-defined event in which a specified component of the reward for producing a block is reduced, often by approximately one half.</p>

                <p>The term is especially associated with Bitcoin, where the <span class="term" data-term="mining/block-subsidy">block subsidy</span> is periodically reduced. Because the subsidy is a source of new issuance, a halving reduces the rate at which new coins enter circulation.</p>

                <h3>Halving and mining</h3>

                <p>For miners, a halving directly changes mining economics. If the coin price, fees, and other parameters remain unchanged, a lower subsidy reduces revenue per successfully mined block.</p>

                <p>Miners can offset part of the effect through changes in asset price, transaction fees, hardware efficiency, electricity costs, or operating conditions. The impact on an individual mining operation therefore depends on its cost structure and other variables.</p>

                <h3>Halving and supply</h3>

                <p>A halving does not destroy existing coins. It changes the future rate of issuance. It should therefore be distinguished from a <span class="term" data-term="cryptocurrency/token-burn">token burn</span>, which removes existing units from supply.</p>'
            ],

            'crypto-asset' => [
                'title' => 'What Is a Cryptoasset | TM Wiki',
                'description' => 'A cryptoasset is a digital asset associated with cryptographic and blockchain infrastructure. Learn about coins, tokens, and asset types.',
                'name' => 'Cryptoasset',
                'caption' => 'A broad term for digital assets using cryptographic and blockchain-related technology.',
                'definition' => '<p>A <strong>cryptoasset</strong> is a broad term for a digital asset that is created, stored, transferred, or accounted for using cryptographic technology and, in many cases, blockchain or other distributed systems.</p>

                <p>Cryptoassets can include <span class="term" data-term="cryptocurrency/coin">coins</span>, <span class="term" data-term="cryptocurrency/token">tokens</span>, stablecoins, and other digital assets. The exact classification depends on the asset’s technical and economic characteristics.</p>

                <h3>Cryptoasset vs. cryptocurrency</h3>

                <p>The terms are sometimes used interchangeably, but cryptoasset is broader. Cryptocurrency is generally associated with an asset used to transfer value or serve as a unit of account, while a cryptoasset can have additional purposes.</p>

                <p>For example, a governance token may primarily be used for protocol governance, while a utility token may provide access to specific functions.</p>

                <h3>Why classification matters</h3>

                <p>Different cryptoassets have different issuance mechanisms, holder rights, risks, custody requirements, and use cases. The fact that an asset exists on a blockchain alone does not fully describe its economic nature.</p>'
            ],

            'market-capitalization' => [
                'title' => 'What Is Crypto Market Cap | TM Wiki',
                'description' => 'Crypto market capitalization is price multiplied by circulating supply. Learn the formula, uses, and limitations of market cap.',
                'name' => 'Market Capitalization',
                'caption' => 'A calculated measure of an asset’s value based on price and circulating supply.',
                'definition' => '<p><strong>Market capitalization</strong> is a calculated metric that estimates the value of a cryptoasset based on its market price and circulating supply.</p>

                <p>The basic formula is:</p>

                <p><strong>Market Cap = Price × Circulating Supply</strong></p>

                <p>For example, if an asset trades at $10 and 20 million units are considered to be in circulation, its calculated market capitalization is $200 million.</p>

                <h3>Why market cap is used</h3>

                <p>The price of an individual coin does not reveal the overall scale of an asset because different assets can have very different supplies. Market capitalization incorporates both price and the number of units in circulation.</p>

                <h3>Limitations</h3>

                <p>Market cap is a calculated metric rather than the amount of money actually invested in the asset. Selling the entire circulating supply at the quoted market price would generally not be possible because available liquidity is limited.</p>

                <p>The calculation also depends on the accuracy of <span class="term" data-term="cryptocurrency/circulating-supply">circulating supply</span> data. Different providers may use different methodologies.</p>

                <p><span class="term" data-term="cryptocurrency/fully-diluted-valuation">Fully Diluted Valuation</span> is used to estimate the value of an asset when its full potential supply is taken into account.</p>'
            ],

            'fully-diluted-valuation' => [
                'title' => 'What Is Crypto FDV | TM Wiki',
                'description' => 'FDV estimates a cryptoasset value using its full potential supply. Learn the formula and how FDV differs from market capitalization.',
                'name' => 'Fully Diluted Valuation',
                'caption' => 'A calculated asset value based on its full potential supply.',
                'definition' => '<p><strong>Fully Diluted Valuation (FDV)</strong> is a calculated metric that estimates the value of a cryptoasset if its entire potential supply were taken into account.</p>

                <p>A simplified formula is:</p>

                <p><strong>FDV = Current Price × Max Supply</strong></p>

                <p>If an asset does not have a fixed maximum supply or uses a dynamic issuance model, FDV can depend on the methodology used to estimate future supply.</p>

                <h3>FDV vs. market capitalization</h3>

                <p><span class="term" data-term="cryptocurrency/market-capitalization">Market capitalization</span> generally uses circulating supply, while FDV uses the full potential supply.</p>

                <p>For example, if a token trades at $2, has 100 million units in circulation, and has a maximum supply of one billion, its market cap is $200 million while its FDV is $2 billion.</p>

                <h3>Why the difference matters</h3>

                <p>A large gap between market cap and FDV can indicate that a substantial portion of the token supply has not yet entered circulation. Future issuance or token unlocks can change available supply and the relative ownership share of existing holders.</p>

                <p>FDV is not a forecast of future market capitalization. It is a calculated value based on the current price and assumed full supply.</p>'
            ],
        ],
    ],

    'crypto-trading' => [
        'title' => 'Crypto Trading Terms',
        'description' => 'Crypto trading glossary covering long, short, leverage, liquidation, funding rate, open interest, margin and other terms.',
        'name' => 'Crypto Trading',
        'caption' => 'Terms used in cryptocurrency trading, including long, short, leverage, liquidation, margin, funding rate, open interest and other concepts.',
        'terms' => [
            'crypto-trading' => [
                'title' => 'What Is Crypto Trading | TM Wiki',
                'description' => 'Crypto trading is the buying and selling of cryptoassets. Learn about spot, derivatives, margin, orders, liquidity, and risk.',
                'name' => 'Crypto Trading',
                'caption' => 'Trading cryptoassets using exchange and market mechanisms.',
                'definition' => '<p><strong>Crypto trading</strong> is the buying and selling of cryptoassets to exchange assets, manage exposure, or seek returns from changes in market prices. Trading can take place on centralized or decentralized venues and can involve direct asset ownership, borrowed capital, or derivative contracts.</p>

                <p>Depending on the market structure, a trader may use <span class="term" data-term="crypto-trading/spot-trading">spot trading</span>, <span class="term" data-term="crypto-trading/margin-trading">margin trading</span>, or <span class="term" data-term="crypto-trading/futures-trading">futures trading</span>. These methods differ in how positions are settled, how leverage is used, how collateral works, and what obligations the trader assumes.</p>

                <h3>How a trade is executed</h3>

                <p>On an exchange, a user submits an <span class="term" data-term="crypto-trading/order-book">order</span> that enters the order book. Depending on the order type, it may execute immediately against available liquidity or wait for a matching order. The final execution price can be affected by the <span class="term" data-term="crypto-trading/spread">spread</span>, market liquidity, and <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <p>Traders also analyze trading volume, volatility, market depth, and, in derivatives markets, open interest and funding rates.</p>

                <h3>Main areas of crypto trading</h3>

                <ul>
                    <li>spot trading;</li>
                    <li>margin trading using borrowed capital;</li>
                    <li>futures and other derivatives trading;</li>
                    <li>hedging price exposure;</li>
                    <li>arbitrage between markets or trading venues.</li>
                </ul>

                <p>Crypto trading involves market risk: the value of a position can move against the trader. When <span class="term" data-term="crypto-trading/leverage">leverage</span> is used, the effect of price movements on the trader’s capital becomes larger, and insufficient collateral can lead to <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>'
            ],

            'spot-trading' => [
                'title' => 'What Is Spot Trading | TM Wiki',
                'description' => 'Spot trading involves buying and selling cryptoassets at current market prices. Learn about orders, settlement, liquidity, and risk.',
                'name' => 'Spot Trading',
                'caption' => 'Trading an asset with direct purchase or sale of the underlying cryptoasset.',
                'definition' => '<p><strong>Spot trading</strong> is the buying and selling of cryptoassets where the transaction is executed under current market conditions and the purchased asset is generally credited to the buyer after execution.</p>

                <p>For example, when a user buys BTC in the spot market, the user exchanges the quoted asset for BTC. Once the trade settles, the BTC belongs to the user and can generally be withdrawn, transferred, or used elsewhere.</p>

                <h3>How the price is formed</h3>

                <p>Spot prices are formed through interaction between buy and sell orders in the <span class="term" data-term="crypto-trading/order-book">order book</span>. Orders can execute at market prices or at prices specified by the trader.</p>

                <p>Important market variables include <span class="term" data-term="crypto-trading/bid">bid</span>, <span class="term" data-term="crypto-trading/ask">ask</span>, and <span class="term" data-term="crypto-trading/spread">spread</span>. When liquidity is insufficient, the actual execution price may differ from the expected price.</p>

                <h3>Spot vs. derivatives</h3>

                <p>The main difference between spot trading and <span class="term" data-term="crypto-trading/derivatives">derivatives</span> trading is that spot trading directly transfers the underlying asset. A derivative contract instead derives its value from the underlying asset and may not involve delivery of that asset.</p>

                <p>Spot trading can also be performed without borrowed capital, although some platforms provide additional financing and margin mechanisms.</p>'
            ],

            'margin-trading' => [
                'title' => 'What Is Margin Trading | TM Wiki',
                'description' => 'Margin trading uses borrowed capital to increase position size. Learn about margin, leverage, liquidation, and trading risk.',
                'name' => 'Margin Trading',
                'caption' => 'Trading with borrowed funds supported by collateral.',
                'definition' => '<p><strong>Margin trading</strong> is trading in which a user uses borrowed capital to increase the size of a position relative to their own funds.</p>

                <p>The trader provides <span class="term" data-term="crypto-trading/margin">margin</span> as collateral for the borrowed funds. The size of the position relative to the trader’s own capital is determined by the available <span class="term" data-term="crypto-trading/leverage">leverage</span>.</p>

                <h3>Example</h3>

                <p>If a trader has $1,000 and uses 5x leverage, the nominal position may be approximately $5,000 under the platform’s rules. A 1% change in the position value corresponds to roughly $50 before fees, interest, and other costs.</p>

                <p>The same mechanism works in reverse: losses are calculated on the larger position and therefore reduce the trader’s own capital more quickly.</p>

                <h3>Liquidation</h3>

                <p>If the value of the collateral becomes insufficient to maintain the position, the trading venue can forcibly close it. This process is called <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>

                <p>Exact rules depend on the exchange, margin type, position mode, and trading instrument. Therefore, the same leverage level does not necessarily imply the same risk on every platform.</p>'
            ],

            'futures-trading' => [
                'title' => 'What Is Futures Trading | TM Wiki',
                'description' => 'Futures trading involves contracts linked to an underlying asset price. Learn about leverage, margin, liquidation, and PnL.',
                'name' => 'Futures Trading',
                'caption' => 'Trading futures contracts whose value is linked to an underlying asset.',
                'definition' => '<p><strong>Futures trading</strong> is trading derivative contracts whose value is linked to the price of an underlying asset. In crypto markets, futures allow traders to take positions on price increases or decreases without necessarily owning the underlying coin.</p>

                <p>A futures contract defines the settlement terms between the parties. Depending on its structure, it may involve delivery of the underlying asset or cash settlement. Crypto platforms commonly offer contracts settled in digital assets or stablecoins.</p>

                <h3>Key elements</h3>

                <ul>
                    <li>contract size and specifications;</li>
                    <li>contract price;</li>
                    <li><span class="term" data-term="crypto-trading/margin">margin collateral</span>;</li>
                    <li><span class="term" data-term="crypto-trading/leverage">leverage</span>;</li>
                    <li>position profit or loss;</li>
                    <li>liquidation conditions.</li>
                </ul>

                <p>Many crypto platforms also offer <span class="term" data-term="crypto-trading/perpetual-futures">perpetual futures</span>, which do not have a fixed expiration date. These contracts use funding rates to help keep their price aligned with the spot market.</p>

                <p>Futures can be used for speculation as well as hedging price exposure. Leverage increases both potential returns and potential losses.</p>'
            ],

            'derivatives' => [
                'title' => 'What Are Derivatives | TM Wiki',
                'description' => 'Derivatives are financial instruments linked to an underlying asset or reference. Learn about futures, options, swaps, and risks.',
                'name' => 'Derivatives',
                'caption' => 'Financial instruments whose value or settlement depends on an underlying asset or reference.',
                'definition' => '<p><strong>Derivatives</strong> are financial instruments whose value or settlement depends on the price, index, rate, or another reference variable. In crypto trading, the underlying asset is often BTC, ETH, or another cryptoasset.</p>

                <p>A derivative does not necessarily involve direct transfer of the underlying asset. Instead, the parties enter into a contract that defines how the financial result changes as the underlying reference changes.</p>

                <h3>Main types</h3>

                <ul>
                    <li><span class="term" data-term="crypto-trading/futures-trading">futures</span>;</li>
                    <li><span class="term" data-term="crypto-trading/perpetual-futures">perpetual futures</span>;</li>
                    <li>options;</li>
                    <li>swaps and other derivative contracts.</li>
                </ul>

                <p>Derivatives can be used for speculation, hedging, risk management, and more complex trading strategies.</p>

                <h3>Main risk</h3>

                <p>Derivative instruments can use leveraged collateral. In that case, a relatively small movement in the underlying asset can produce a much larger change in the position result. Insufficient collateral can lead to <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>'
            ],

            'perpetual-futures' => [
                'title' => 'What Are Perpetual Futures | TM Wiki',
                'description' => 'Perpetual futures are derivatives without a fixed expiration date. Learn about funding rates, margin, leverage, and liquidation.',
                'name' => 'Perpetual Futures',
                'caption' => 'Futures-like contracts without a fixed expiration date.',
                'definition' => '<p><strong>Perpetual futures</strong> are derivative contracts that allow traders to gain exposure to changes in an underlying asset price without a fixed expiration date.</p>

                <p>A traditional futures contract has an expiration or settlement date. A perpetual contract can remain open indefinitely as long as the trader maintains sufficient collateral and follows the platform’s requirements.</p>

                <h3>Funding rate</h3>

                <p>Perpetual contracts use a <span class="term" data-term="crypto-trading/funding-rate">funding rate</span> mechanism to help keep the contract price close to the spot price. Periodic payments between market participants depend on the relationship between the contract price and the spot reference.</p>

                <p>Depending on the funding rate, one side of the market pays the other. Funding is therefore a balancing mechanism rather than a standard trading fee.</p>

                <h3>Margin and liquidation</h3>

                <p>Perpetual futures generally support <span class="term" data-term="crypto-trading/leverage">leverage</span>. When the market moves against a position, its collateral decreases, and reaching the required threshold can trigger <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>'
            ],

            'leverage' => [
                'title' => 'What Is Leverage in Trading | TM Wiki',
                'description' => 'Leverage increases position size relative to a trader’s own capital. Learn about the formula, returns, losses, and liquidation risk.',
                'name' => 'Leverage',
                'caption' => 'A mechanism that increases position exposure using borrowed capital or margin.',
                'definition' => '<p><strong>Leverage</strong> is a mechanism that allows a trader to open a position larger than their own available capital.</p>

                <p>If a trader uses 10x leverage and provides $1,000 of their own capital as collateral, the nominal position may be up to $10,000 under the platform’s rules.</p>

                <h3>Formula</h3>

                <p>In simplified form, leverage can be represented as the ratio of position size to the trader’s own capital:</p>

                <p><strong>Leverage = Position Size / Trader Capital</strong></p>

                <p>The higher the leverage, the smaller the market movement required to produce a large percentage change relative to the trader’s own capital.</p>

                <h3>Leverage and risk</h3>

                <p>Leverage does not change the market movement itself. It changes the financial effect of that movement relative to the trader’s collateral. It therefore increases both potential returns and potential losses.</p>

                <p>Insufficient collateral can cause a position to reach its <span class="term" data-term="crypto-trading/liquidation">liquidation</span> level. The exact level depends on margin, position size, price, fees, and exchange rules.</p>'
            ],

            'margin' => [
                'title' => 'What Is Margin in Trading | TM Wiki',
                'description' => 'Margin is collateral used to open and maintain leveraged positions. Learn about initial margin, maintenance margin, and liquidation.',
                'name' => 'Margin',
                'caption' => 'Funds used as collateral for a leveraged or derivative trading position.',
                'definition' => '<p><strong>Margin</strong> is collateral used to open and maintain a position when trading with borrowed capital or derivatives.</p>

                <p>Margin does not necessarily equal the full value of a position. When <span class="term" data-term="crypto-trading/leverage">leverage</span> is used, the trader provides only part of the position value as collateral while the remaining exposure is supported by the platform’s financing mechanism.</p>

                <h3>Types of margin</h3>

                <ul>
                    <li><span class="term" data-term="crypto-trading/initial-margin">initial margin</span> — the minimum collateral required to open a position;</li>
                    <li><span class="term" data-term="crypto-trading/maintenance-margin">maintenance margin</span> — the minimum collateral required to keep an existing position open.</li>
                </ul>

                <p>If the collateral falls below the required threshold, the exchange may initiate <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>

                <p>Platforms can also offer different margin modes, such as isolated and cross margin. Under isolated margin, the risk is generally limited to the collateral assigned to a specific position, while cross margin can use available account balance to support multiple positions.</p>'
            ],

            'initial-margin' => [
                'title' => 'What Is Initial Margin | TM Wiki',
                'description' => 'Initial margin is the collateral required to open a trading position. Learn how it relates to leverage, position size, and risk.',
                'name' => 'Initial Margin',
                'caption' => 'The minimum collateral required to open a trading position.',
                'definition' => '<p><strong>Initial margin</strong> is the amount of collateral required to open a particular leveraged or derivative position.</p>

                <p>Initial margin is related to the nominal position size and available <span class="term" data-term="crypto-trading/leverage">leverage</span>. In a simplified model, 10x leverage corresponds to initial margin of approximately 10% of the nominal position size, before fees and platform-specific adjustments.</p>

                <p><strong>Initial Margin ≈ Position Size / Leverage</strong></p>

                <h3>Example</h3>

                <p>A $10,000 position using 5x leverage requires approximately $2,000 of initial collateral. Actual exchange requirements can differ because of position tiers, volatility, fees, and other parameters.</p>

                <p>Initial margin should be distinguished from <span class="term" data-term="crypto-trading/maintenance-margin">maintenance margin</span>, which determines the minimum collateral required after the position has been opened.</p>'
            ],

            'maintenance-margin' => [
                'title' => 'What Is Maintenance Margin | TM Wiki',
                'description' => 'Maintenance margin is the minimum collateral required to keep a position open. Learn about liquidation thresholds and risk.',
                'name' => 'Maintenance Margin',
                'caption' => 'The minimum collateral level required to maintain an open position.',
                'definition' => '<p><strong>Maintenance margin</strong> is the minimum collateral level that must be maintained to keep a leveraged or derivative position open.</p>

                <p>After a position is opened, its value changes with the market. Losses reduce the available collateral. If collateral reaches the maintenance margin threshold, the exchange may initiate <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>

                <h3>Initial margin vs. maintenance margin</h3>

                <p><span class="term" data-term="crypto-trading/initial-margin">Initial margin</span> is the requirement for opening a position. Maintenance margin is the threshold that must remain available after the position is open.</p>

                <p>Maintenance margin is generally lower than initial margin. This allows a position to remain open after entry while the trader still has sufficient collateral to cover potential losses.</p>

                <p>Exact values and calculation methods depend on the exchange, instrument, position size, and margin mode.</p>'
            ],

            'liquidation' => [
                'title' => 'What Is Liquidation in Trading | TM Wiki',
                'description' => 'Liquidation is the forced closure of a position when collateral becomes insufficient. Learn how liquidation works and why leverage matters.',
                'name' => 'Liquidation',
                'caption' => 'Forced closure of a trading position because available collateral is insufficient.',
                'definition' => '<p><strong>Liquidation</strong> is the forced closure of a leveraged or derivative position by a trading platform when the available collateral is no longer sufficient under its risk rules.</p>

                <p>The primary cause is an adverse price movement that creates losses and reduces the equity supporting the position.</p>

                <h3>How liquidation works</h3>

                <p>When collateral approaches the critical threshold defined by <span class="term" data-term="crypto-trading/maintenance-margin">maintenance margin</span>, the platform may begin closing the position. The exact process varies by exchange: a position may be closed completely or partially, and the exchange may use its own risk-management mechanism.</p>

                <p>The price level associated with the risk of forced closure is called the <span class="term" data-term="crypto-trading/liquidation-price">liquidation price</span>.</p>

                <h3>Why leverage increases risk</h3>

                <p>With high <span class="term" data-term="crypto-trading/leverage">leverage</span>, a relatively small percentage move in the market can produce a large loss relative to the trader’s collateral. As a result, the distance between the current price and liquidation price generally becomes smaller as leverage increases.</p>'
            ],

            'liquidation-price' => [
                'title' => 'What Is Liquidation Price | TM Wiki',
                'description' => 'Liquidation price is the price level at which a leveraged position may be forcibly closed because collateral is insufficient.',
                'name' => 'Liquidation Price',
                'caption' => 'The calculated price level at which a position becomes subject to forced closure.',
                'definition' => '<p><strong>Liquidation price</strong> is the calculated price level of the underlying asset at which the collateral supporting a trading position becomes insufficient and the exchange may begin forced closure.</p>

                <p>The liquidation price depends on position direction, position size, <span class="term" data-term="crypto-trading/margin">margin</span>, <span class="term" data-term="crypto-trading/leverage">leverage</span>, maintenance margin, fees, and the exchange’s risk rules.</p>

                <h3>Long and short positions</h3>

                <p>For a <span class="term" data-term="crypto-trading/long-position">long position</span>, liquidation risk increases when the price falls significantly. For a <span class="term" data-term="crypto-trading/short-position">short position</span>, the critical movement is a significant price increase.</p>

                <p>In simplified terms, the smaller the trader’s own collateral relative to position size, the smaller the adverse market movement required to reach liquidation.</p>

                <h3>Why calculations differ</h3>

                <p>Exchanges use different formulas and parameters. Calculations can include maintenance margin, closing fees, position size, cross or isolated margin, and other variables.</p>

                <p>Liquidation price should therefore be treated as a position-specific metric rather than a universal market value.</p>'
            ],

            'long-position' => [
                'title' => 'What Is a Long Position | TM Wiki',
                'description' => 'A long position benefits from a rise in the underlying asset price. Learn about profit, loss, leverage, and liquidation risk.',
                'name' => 'Long Position',
                'caption' => 'A position designed to benefit from an increase in the underlying asset price.',
                'definition' => '<p>A <strong>long position</strong> is a trading position in which the trader benefits when the underlying asset price rises and loses when the price falls, all else being equal.</p>

                <p>In spot trading, buying an asset generally creates long exposure to its price. In derivatives, a long position can be created through a contract without directly owning the underlying asset.</p>

                <h3>Example</h3>

                <p>If a trader opens a BTC long position at $60,000 and closes it at $63,000, the price change is +5%. Without leverage, this corresponds to approximately a 5% position return before fees and other costs.</p>

                <p>With <span class="term" data-term="crypto-trading/leverage">leverage</span>, the percentage result relative to the trader’s own capital can be much larger, but so can the risk of loss and <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>'
            ],

            'short-position' => [
                'title' => 'What Is a Short Position | TM Wiki',
                'description' => 'A short position benefits from a decline in the asset price. Learn about the mechanism, leverage, losses, and liquidation.',
                'name' => 'Short Position',
                'caption' => 'A position designed to benefit from a decline in the underlying asset price.',
                'definition' => '<p>A <strong>short position</strong> is a trading position in which the trader benefits when the underlying asset price falls and loses when the price rises, all else being equal.</p>

                <p>In derivatives trading, a short is generally opened by selling the relevant contract. In traditional margin structures, a borrowed asset can also be sold with the intention of buying it back later at a lower price.</p>

                <h3>Example</h3>

                <p>If a BTC short position is opened at $60,000 and closed at $57,000, the price change is approximately -5%, which corresponds to approximately a 5% positive position result before costs.</p>

                <p>If the price rises instead, the position loses value. With <span class="term" data-term="crypto-trading/leverage">leverage</span>, a strong price increase can lead to <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>

                <p>Unlike a long position, the theoretical loss on an unhedged short position can be very large because an asset price has no fixed upper limit.</p>'
            ],

            'market-order' => [
                'title' => 'What Is a Market Order | TM Wiki',
                'description' => 'A market order executes against available prices in the order book. Learn about execution, liquidity, and slippage.',
                'name' => 'Market Order',
                'caption' => 'An order designed to execute immediately against available market prices.',
                'definition' => '<p>A <strong>market order</strong> is an instruction to buy or sell an asset that executes against the best available prices in the current <span class="term" data-term="crypto-trading/order-book">order book</span>.</p>

                <p>Unlike a limit order, a market order generally does not specify an exact execution price. Its primary objective is immediate execution against available liquidity.</p>

                <h3>How a market order executes</h3>

                <p>A market buy order is matched against available sell offers, starting with the most favorable available price. If the order is large, it can consume liquidity across multiple price levels.</p>

                <p>As a result, the average execution price can differ from the price displayed immediately before the order was submitted. This is known as <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <h3>When market orders are used</h3>

                <p>Market orders are useful when immediate execution is more important than controlling the exact execution price. On markets with limited liquidity, however, a large market order can move through several price levels and produce significant slippage.</p>'
            ],

            'limit-order' => [
                'title' => 'What Is a Limit Order | TM Wiki',
                'description' => 'A limit order specifies the maximum buy or minimum sell price. Learn about execution, order books, and liquidity.',
                'name' => 'Limit Order',
                'caption' => 'An order to buy or sell at a specified price or a more favorable price.',
                'definition' => '<p>A <strong>limit order</strong> is an order to buy or sell an asset at a specified price or a more favorable price.</p>

                <p>For a buy order, the limit price generally represents the maximum price the trader is willing to pay. For a sell order, it represents the minimum price the trader is willing to accept.</p>

                <h3>Example</h3>

                <p>If BTC is trading around $60,000 and a user places a buy limit order at $59,000, the order should not execute above that price. It will wait for suitable liquidity or may execute partially.</p>

                <p>Limit orders provide liquidity to the <span class="term" data-term="crypto-trading/order-book">order book</span>. Depending on exchange rules, an order that adds liquidity may be classified as a maker order.</p>

                <h3>Advantage and limitation</h3>

                <p>The main advantage is control over the maximum or minimum execution price. The limitation is that the order may never execute, or it may execute only partially, if the market does not reach the specified price.</p>'
            ],

            'stop-order' => [
                'title' => 'What Is a Stop Order | TM Wiki',
                'description' => 'A stop order activates when a specified price is reached. Learn about triggers, stop-loss, take-profit, and execution risk.',
                'name' => 'Stop Order',
                'caption' => 'A conditional order activated after the market reaches a specified price level.',
                'definition' => '<p>A <strong>stop order</strong> is a conditional order that activates when the market reaches a specified trigger price, also called a stop price.</p>

                <p>Before the trigger condition is reached, the order generally does not execute like an ordinary active order. After activation, it may become a market or limit order depending on the stop-order type and exchange rules.</p>

                <h3>Main uses</h3>

                <ul>
                    <li><span class="term" data-term="crypto-trading/stop-loss">stop-loss</span> — limiting losses or protecting part of an existing gain;</li>
                    <li><span class="term" data-term="crypto-trading/take-profit">take-profit</span> — automatically closing a position at a target level.</li>
                </ul>

                <p>The trigger price and actual execution price are not necessarily the same. If activation produces a market order, rapid price movement can cause <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>'
            ],

            'stop-loss' => [
                'title' => 'What Is Stop-Loss | TM Wiki',
                'description' => 'A stop-loss is a conditional order used to limit losses or protect gains. Learn how it works and why execution may differ.',
                'name' => 'Stop-Loss',
                'caption' => 'An order designed to automatically exit a position after an adverse price move.',
                'definition' => '<p><strong>Stop-loss</strong> is a conditional trading order designed to automatically close a position when a specified price level is reached.</p>

                <p>For a long position, a stop-loss is generally placed below the current price. For a short position, it is generally placed above the current price. When the trigger level is reached, the stop order activates according to its configured execution type.</p>

                <h3>Example</h3>

                <p>A trader buys BTC at $60,000 and sets a stop-loss at $57,000. If the market reaches the trigger level, the system initiates a position-closing order. If the stop becomes a market order, the final execution price may differ from $57,000.</p>

                <h3>Limitations</h3>

                <p>A stop-loss does not guarantee execution at the exact specified price. Rapid market movement, low liquidity, or price gaps can cause <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <p>Stop-loss is a risk-management tool, but it does not eliminate market risk.</p>'
            ],

            'take-profit' => [
                'title' => 'What Is Take-Profit | TM Wiki',
                'description' => 'A take-profit order automatically closes a position at a target price. Learn how it works and how it differs from stop-loss.',
                'name' => 'Take-Profit',
                'caption' => 'An order designed to automatically close a position at a target price level.',
                'definition' => '<p><strong>Take-profit</strong> is a conditional order used to automatically close a trading position after a predefined target price is reached.</p>

                <p>For a long position, the take-profit level is generally above the entry price. For a short position, it is generally below the entry price.</p>

                <h3>Example</h3>

                <p>If a trader opens a BTC long position at $60,000 and sets take-profit at $65,000, reaching the specified level activates an order to close the position. Depending on the order design, execution may use a market or limit mechanism.</p>

                <p>When market execution is used, the actual execution price can differ from the trigger level because of <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <h3>Take-profit vs. stop-loss</h3>

                <p>Stop-loss is primarily designed to manage an adverse price movement, while take-profit is designed to automatically realize a result after a target level is reached. Both are conditional order mechanisms.</p>'
            ],

            'spread' => [
                'title' => 'What Is Spread in Trading | TM Wiki',
                'description' => 'The spread is the difference between the best bid and ask prices. Learn about liquidity, execution costs, and order books.',
                'name' => 'Spread',
                'caption' => 'The difference between the best available buy and sell prices.',
                'definition' => '<p><strong>Spread</strong> is the difference between the best available buy price (<span class="term" data-term="crypto-trading/bid">bid</span>) and the best available sell price (<span class="term" data-term="crypto-trading/ask">ask</span>) in a market.</p>

                <p>The basic formula is:</p>

                <p><strong>Spread = Ask − Bid</strong></p>

                <p>For example, if the best bid is $59,990 and the best ask is $60,010, the absolute spread is $20.</p>

                <h3>What spread indicates</h3>

                <p>A small spread means the best buy and sell prices are close together. A large spread can occur in less liquid markets or during periods of increased uncertainty and rapid price movement.</p>

                <p>For a trader, the spread is part of the effective cost of immediate execution. Buying at the ask and selling immediately at the bid in an otherwise unchanged market produces a negative result equal to the spread before fees.</p>

                <h3>Spread and liquidity</h3>

                <p>Spread is closely related to the condition of the <span class="term" data-term="crypto-trading/order-book">order book</span>. A market with many orders close to the current price can maintain a relatively small spread.</p>'
            ],

            'slippage' => [
                'title' => 'What Is Slippage in Trading | TM Wiki',
                'description' => 'Slippage is the difference between expected and actual execution price. Learn about causes, effects, and ways to reduce it.',
                'name' => 'Slippage',
                'caption' => 'The difference between an expected and actual order execution price.',
                'definition' => '<p><strong>Slippage</strong> is the difference between the price a trader expected when placing an order and the actual execution price or average execution price.</p>

                <p>Slippage commonly occurs when large market orders consume multiple price levels, when liquidity is limited, or when the market moves rapidly.</p>

                <h3>Example</h3>

                <p>Suppose the best available BTC sell price is $60,000, but only a small amount is available there. A large market buy order may execute at $60,000, then $60,020, $60,050, and higher levels. The resulting average price is higher than the initially displayed price.</p>

                <p>Slippage depends on order size, <span class="term" data-term="crypto-trading/order-book">order-book</span> depth, volatility, and how quickly market prices are changing.</p>

                <h3>Reducing slippage</h3>

                <ul>
                    <li>use limit orders when appropriate;</li>
                    <li>split large orders into smaller parts;</li>
                    <li>trade on more liquid markets;</li>
                    <li>check <span class="term" data-term="crypto-trading/market-depth">market depth</span> before placing large orders.</li>
                </ul>'
            ],

            'market-depth' => [
                'title' => 'What Is Market Depth | TM Wiki',
                'description' => 'Market depth shows buy and sell order volumes at different prices. Learn how depth relates to liquidity and slippage.',
                'name' => 'Market Depth',
                'caption' => 'The volume of available buy and sell orders at different price levels.',
                'definition' => '<p><strong>Market depth</strong> shows how much buy and sell liquidity is available at different price levels around the current market price.</p>

                <p>Depth information is normally represented by the <span class="term" data-term="crypto-trading/order-book">order book</span>. Buy orders form the bid side, while sell orders form the ask side.</p>

                <h3>Why market depth matters</h3>

                <p>A deep market can absorb relatively large orders with less price impact. In a shallow market, even a moderate order can consume several price levels and produce significant <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <p>Trading volume alone does not fully describe liquidity. Two markets can have similar daily volume but very different order-book depth.</p>

                <h3>Visualization</h3>

                <p>Exchanges often display market depth as a table or depth chart. It shows cumulative order volume on both sides of the current price and helps traders estimate the potential price impact of larger orders.</p>'
            ],

            'order-book' => [
                'title' => 'What Is an Order Book | TM Wiki',
                'description' => 'An order book contains active buy and sell orders. Learn about bids, asks, spread, market depth, and trade execution.',
                'name' => 'Order Book',
                'caption' => 'A list of active buy and sell orders on a trading venue.',
                'definition' => '<p>An <strong>order book</strong> is a data structure maintained by a trading venue that contains active buy and sell orders for a particular asset.</p>

                <p>Buy orders form the <span class="term" data-term="crypto-trading/bid">bid</span> side, while sell orders form the <span class="term" data-term="crypto-trading/ask">ask</span> side. Orders are generally organized by price and quantity.</p>

                <h3>How matching works</h3>

                <p>When a new order crosses an existing opposite-side order, the trading system can match them and execute a trade. This is the basis of <span class="term" data-term="crypto-exchanges/order-matching">order matching</span> on exchange markets.</p>

                <p>If a limit order cannot execute immediately, it generally remains in the order book until it is filled, canceled, or expires according to the venue’s rules.</p>

                <h3>What the order book shows</h3>

                <ul>
                    <li>best bid;</li>
                    <li>best ask;</li>
                    <li>order quantities;</li>
                    <li>spread;</li>
                    <li>volume at different price levels;</li>
                    <li>market depth.</li>
                </ul>

                <p>The order book is dynamic: orders are continuously added, canceled, and executed. Its state can therefore change substantially over a short period of time.</p>'
            ],

            'bid' => [
                'title' => 'What Is Bid in Trading | TM Wiki',
                'description' => 'Bid is the best available buy price in an order book. Learn about bid, ask, spread, and market-order execution.',
                'name' => 'Bid',
                'caption' => 'The price buyers are willing to pay for an asset.',
                'definition' => '<p><strong>Bid</strong> is the price at which a buyer is willing to purchase an asset. In an order book, bid generally refers to the buy side of the market.</p>

                <p><strong>Best bid</strong> is the highest available price among active buy orders. For example, if buyers are bidding $59,900, $59,950, and $60,000, the best bid is $60,000.</p>

                <h3>Bid and ask</h3>

                <p>The opposite side consists of <span class="term" data-term="crypto-trading/ask">ask</span> orders from sellers. The difference between the best bid and best ask is the <span class="term" data-term="crypto-trading/spread">spread</span>.</p>

                <p>A trader using a market order to sell will generally execute against available bid orders. A trader using a market order to buy will generally execute against available ask orders.</p>'
            ],

            'ask' => [
                'title' => 'What Is Ask in Trading | TM Wiki',
                'description' => 'Ask is the best available sell price in an order book. Learn about ask, bid, spread, and market-order execution.',
                'name' => 'Ask',
                'caption' => 'The price sellers are willing to accept for an asset.',
                'definition' => '<p><strong>Ask</strong> is the price at which a seller is willing to sell an asset. In an order book, ask refers to the sell side of the market.</p>

                <p><strong>Best ask</strong> is the lowest available price among active sell orders. For example, if sellers offer an asset at $60,100, $60,050, and $60,000, the best ask is $60,000.</p>

                <h3>Ask and bid</h3>

                <p>The opposite side consists of <span class="term" data-term="crypto-trading/bid">bid</span> orders from buyers. The difference between the best ask and best bid forms the <span class="term" data-term="crypto-trading/spread">spread</span>.</p>

                <p>A market buy order generally executes against available ask orders. If the buy order is larger than the quantity available at the best ask, it can continue through additional price levels.</p>'
            ],

            'trading-volume' => [
                'title' => 'What Is Trading Volume | TM Wiki',
                'description' => 'Trading volume measures the amount or value of assets traded during a period. Learn how volume is calculated and its limits.',
                'name' => 'Trading Volume',
                'caption' => 'The amount or value of assets traded during a specified period.',
                'definition' => '<p><strong>Trading volume</strong> is a measure of the quantity or monetary value of assets involved in executed trades during a specified period.</p>

                <p>In crypto markets, volume is often reported in the base asset or quoted currency, such as USDT. The measurement period can be one minute, one hour, one day, or another interval.</p>

                <h3>What volume shows</h3>

                <p>Trading volume provides information about market activity. Higher volume means that more trades or a larger notional amount were executed during the measured period.</p>

                <p>However, high volume does not automatically mean high <span class="term" data-term="crypto-trading/market-depth">market depth</span>. Volume measures completed trades, while market depth measures currently available orders in the order book.</p>

                <h3>Limitations</h3>

                <p>Different exchanges can report different volumes for the same asset. Data quality also depends on the venue, measurement methodology, and selected time period.</p>'
            ],

            'volatility' => [
                'title' => 'What Is Volatility | TM Wiki',
                'description' => 'Volatility measures the intensity of price changes. Learn about historical and implied volatility and its role in crypto trading.',
                'name' => 'Volatility',
                'caption' => 'The degree and speed of price variation over a given period.',
                'definition' => '<p><strong>Volatility</strong> is a measure of how much and how rapidly an asset’s price or returns vary over a particular period. Larger and more frequent price deviations generally correspond to higher observed volatility.</p>

                <p>Crypto markets can experience substantial volatility because they trade continuously and are affected by changing liquidity, news, expectations, and other market factors.</p>

                <h3>Historical and implied volatility</h3>

                <p><strong>Historical volatility</strong> is calculated from observed past price movements. <strong>Implied volatility</strong> is primarily used in options markets and reflects expectations embedded in option prices.</p>

                <h3>Volatility and risk</h3>

                <p>High volatility means that prices can travel significant distances quickly. For a trader, this creates both greater potential for changes in position value and greater risk of adverse movement.</p>

                <p>When <span class="term" data-term="crypto-trading/leverage">leverage</span> is used, high volatility becomes particularly important because a sharp price move can quickly bring a position closer to <span class="term" data-term="crypto-trading/liquidation">liquidation</span>.</p>'
            ],

            'funding-rate' => [
                'title' => 'What Is Funding Rate | TM Wiki',
                'description' => 'Funding rate determines periodic payments between perpetual-futures traders. Learn how funding works and affects positions.',
                'name' => 'Funding Rate',
                'caption' => 'A periodic financing rate exchanged between participants in perpetual futures markets.',
                'definition' => '<p><strong>Funding rate</strong> is a rate used to determine periodic payments between participants in the market for <span class="term" data-term="crypto-trading/perpetual-futures">perpetual futures</span>.</p>

                <p>The funding mechanism helps keep the perpetual contract price connected to the spot price of the underlying asset. When the contract deviates from the spot market, funding can create an economic incentive for traders to adjust their positions.</p>

                <h3>How funding works</h3>

                <p>Depending on the funding rate, one side of the market pays the other. Under a common convention, positive funding means long positions pay short positions. Negative funding reverses the payment direction.</p>

                <p>Exact rules, intervals, and formulas are determined by each trading venue.</p>

                <h3>Effect on traders</h3>

                <p>If a position remains open through multiple funding periods, payments received or paid affect its total financial result. Therefore, the profitability of a perpetual position cannot be evaluated from price movement alone.</p>

                <p>Funding is a transfer between market participants and should not automatically be treated as an ordinary exchange trading fee.</p>'
            ],

            'open-interest' => [
                'title' => 'What Is Open Interest | TM Wiki',
                'description' => 'Open interest measures outstanding derivative positions. Learn about OI, changes in OI, and its difference from trading volume.',
                'name' => 'Open Interest',
                'caption' => 'The amount of open derivative contracts that have not yet been closed or settled.',
                'definition' => '<p><strong>Open interest (OI)</strong> measures the number or notional value of derivative contracts that remain open and have not yet been closed, settled, or exercised.</p>

                <p>The metric is particularly important in futures and other derivatives markets. It represents accumulated open exposure rather than the number of trades executed during a particular period.</p>

                <h3>Open interest vs. trading volume</h3>

                <p><span class="term" data-term="crypto-trading/trading-volume">Trading volume</span> measures the amount of trading activity completed during a period. Open interest measures the contracts that remain open.</p>

                <p>For example, when two traders open a new futures contract, open interest increases. When an existing position is fully closed, open interest decreases. A transfer of an existing position can have a different effect depending on how the transaction is structured.</p>

                <h3>How OI is used</h3>

                <p>Traders use open interest to assess the amount of capital and exposure currently committed to derivative markets. Changes in OI are often considered alongside price, volume, and <span class="term" data-term="crypto-trading/funding-rate">funding rate</span>.</p>

                <p>A rise or fall in open interest by itself does not determine the future direction of price. OI describes outstanding contracts rather than providing a guaranteed market forecast.</p>'
            ],
        ],
    ],

    'crypto-exchanges' => [
        'title' => 'Crypto Exchange Terms',
        'description' => 'Crypto exchange glossary covering CEX, DEX, orders, order books, maker, taker, liquidity, fees and other terms.',
        'name' => 'Crypto Exchanges',
        'caption' => 'Terms related to cryptocurrency exchanges, including CEX, DEX, orders, order books, liquidity, maker, taker, fees and other concepts.',
        'terms' => [
            'crypto-exchange' => [
                'title' => 'What Is a Crypto Exchange | TM Wiki',
                'description' => 'A crypto exchange is a platform for buying, selling, and exchanging crypto assets, including spot and derivatives trading.',
                'name' => 'Crypto Exchange',
                'caption' => 'A platform for trading and exchanging crypto assets.',
                'definition' => '<p>A <strong>crypto exchange</strong> is a platform where users can buy, sell, and exchange <span class="term" data-term="cryptocurrency/crypto-asset">crypto assets</span>. Depending on its architecture, an exchange may be centralized or decentralized and may support <span class="term" data-term="crypto-trading/spot-trading">spot trading</span>, <span class="term" data-term="crypto-trading/margin-trading">margin trading</span>, <span class="term" data-term="crypto-trading/futures-trading">futures trading</span>, and other <span class="term" data-term="crypto-trading/derivatives">derivatives</span>.</p>

                <p>A centralized exchange normally holds user funds through its <span class="term" data-term="crypto-exchanges/exchange-wallet">exchange wallets</span> and maintains internal account balances. Trading orders are processed through <span class="term" data-term="crypto-exchanges/order-matching">order matching</span>, while the <span class="term" data-term="crypto-exchanges/matching-engine">matching engine</span> finds compatible buy and sell orders. A decentralized exchange instead relies on <span class="term" data-term="blockchain/smart-contract">smart contracts</span> and blockchain infrastructure to execute trades without traditional centralized custody.</p>

                <h3>Main functions of a crypto exchange</h3>
                <ul>
                    <li>buying and selling crypto assets;</li>
                    <li>exchanging one <span class="term" data-term="cryptocurrency/coin">coin</span> or <span class="term" data-term="cryptocurrency/token">token</span> for another asset;</li>
                    <li>placing <span class="term" data-term="crypto-trading/market-order">market orders</span> and <span class="term" data-term="crypto-trading/limit-order">limit orders</span>;</li>
                    <li>depositing and withdrawing funds;</li>
                    <li>holding assets within exchange infrastructure;</li>
                    <li>providing market data such as <span class="term" data-term="crypto-trading/order-book">order books</span>, <span class="term" data-term="crypto-trading/trading-volume">trading volume</span>, and prices.</li>
                </ul>

                <p>When using an exchange, users need to consider <span class="term" data-term="crypto-exchanges/trading-fee">trading fees</span>, withdrawal fees, market liquidity, <span class="term" data-term="crypto-trading/spread">spread</span>, and possible <span class="term" data-term="crypto-trading/slippage">slippage</span>. Centralized exchanges may also require <span class="term" data-term="crypto-exchanges/kyc">KYC</span> and <span class="term" data-term="crypto-exchanges/aml">AML</span> procedures.</p>'
            ],

            'centralized-exchange' => [
                'title' => 'What Is a Centralized Exchange | TM Wiki',
                'description' => 'A centralized exchange is operated by a single organization that manages trading infrastructure, accounts, and usually asset custody.',
                'name' => 'Centralized Exchange',
                'caption' => 'An exchange operated and managed by a central organization.',
                'definition' => '<p>A <strong>centralized exchange</strong> (CEX) is a crypto exchange operated by a single organization. The operator manages the trading infrastructure, user accounts, internal balances, and usually the <span class="term" data-term="crypto-exchanges/exchange-wallet">exchange wallets</span> holding customer assets.</p>

                <p>Users interact with the platform through an <span class="term" data-term="crypto-exchanges/exchange-account">exchange account</span>. After depositing funds, the exchange records the corresponding balance in its internal system. Trading is normally performed through a centralized <span class="term" data-term="crypto-exchanges/matching-engine">matching engine</span> that handles <span class="term" data-term="crypto-exchanges/order-matching">order matching</span>.</p>

                <h3>Key characteristics of a CEX</h3>
                <ul>
                    <li>centralized management;</li>
                    <li>internal accounting of trading balances;</li>
                    <li>centralized order execution;</li>
                    <li>exchange-controlled asset custody;</li>
                    <li>frequent use of <span class="term" data-term="crypto-exchanges/kyc">KYC</span> and <span class="term" data-term="crypto-exchanges/aml">AML</span> procedures;</li>
                    <li>support for multiple trading pairs and order types.</li>
                </ul>

                <p>The main difference between a CEX and a <span class="term" data-term="crypto-exchanges/decentralized-exchange">decentralized exchange</span> is the trust model. With a CEX, users give the operator a degree of control over assets and trading operations. Account security, custody practices, withdrawal policies, and the operator’s infrastructure therefore become important considerations.</p>'
            ],

            'decentralized-exchange' => [
                'title' => 'What Is a Decentralized Exchange | TM Wiki',
                'description' => 'A decentralized exchange enables crypto asset trading through blockchain infrastructure and smart contracts.',
                'name' => 'Decentralized Exchange',
                'caption' => 'A blockchain-based exchange using smart contracts.',
                'definition' => '<p>A <strong>decentralized exchange</strong> (DEX) is a protocol or application for exchanging <span class="term" data-term="cryptocurrency/crypto-asset">crypto assets</span> where key operations are executed on a <span class="term" data-term="blockchain/blockchain">blockchain</span> through <span class="term" data-term="blockchain/smart-contract">smart contracts</span>.</p>

                <p>Unlike a centralized exchange, a DEX generally does not require users to deposit assets with a traditional exchange operator for ordinary swaps. Users connect a <span class="term" data-term="crypto-wallets/non-custodial-wallet">non-custodial wallet</span>, authorize the transaction, and interact directly with the protocol. Trading may rely on an <span class="term" data-term="deFi/automated-market-maker">automated market maker</span> and <span class="term" data-term="deFi/liquidity-pool">liquidity pool</span>.</p>

                <h3>How a DEX works</h3>
                <p>The user selects an asset to sell and an asset to receive. The protocol calculates the <span class="term" data-term="deFi/swap">swap</span> according to available liquidity and the rules of its smart contracts. The final result may be affected by <span class="term" data-term="crypto-trading/slippage">slippage</span>, protocol fees, and the <span class="term" data-term="blockchain/transaction-fee">blockchain transaction fee</span>.</p>

                <p>A DEX reduces the need to trust a centralized operator, but introduces or shifts risks toward smart contracts, oracles, liquidity, and blockchain infrastructure. Users therefore also need to consider smart-contract risks and the quality of available <span class="term" data-term="security/smart-contract-audit">smart-contract audits</span>.</p>'
            ],

            'exchange-account' => [
                'title' => 'What Is an Exchange Account | TM Wiki',
                'description' => 'An exchange account is a user account used for trading, deposits, withdrawals, and managing crypto assets.',
                'name' => 'Exchange Account',
                'caption' => 'A user account on a cryptocurrency exchange.',
                'definition' => '<p>An <strong>exchange account</strong> is a user account on a crypto exchange that provides access to trading, balances, deposits, withdrawals, and account management functions. On a centralized platform, the account is normally connected to internal asset accounting and security settings.</p>

                <p>After registration, a user may complete <span class="term" data-term="crypto-exchanges/kyc">KYC</span>, configure two-factor authentication, add withdrawal addresses, and deposit funds. Available functions depend on the exchange, jurisdiction, and verification status.</p>

                <h3>What an exchange account may contain</h3>
                <ul>
                    <li>balances of different <span class="term" data-term="cryptocurrency/crypto-asset">crypto assets</span>;</li>
                    <li>trade and order history;</li>
                    <li>deposit addresses;</li>
                    <li>deposit and withdrawal history;</li>
                    <li>security settings;</li>
                    <li>access to spot and other trading products.</li>
                </ul>

                <p>An exchange account should be distinguished from a <span class="term" data-term="crypto-wallets/crypto-wallet">crypto wallet</span>. On a centralized exchange, a user balance is often an internal ledger entry, while a non-custodial wallet gives the user direct control over the corresponding <span class="term" data-term="crypto-wallets/private-key">private key</span>.</p>'
            ],

            'exchange-wallet' => [
                'title' => 'What Is an Exchange Wallet | TM Wiki',
                'description' => 'An exchange wallet is infrastructure used by a crypto exchange to store and process customer deposits and withdrawals.',
                'name' => 'Exchange Wallet',
                'caption' => 'A wallet infrastructure used by a crypto exchange.',
                'definition' => '<p>An <strong>exchange wallet</strong> is cryptocurrency wallet infrastructure used by an exchange to receive, hold, and send <span class="term" data-term="cryptocurrency/crypto-asset">crypto assets</span>. Centralized exchanges may use such wallets to manage assets belonging to many customers.</p>

                <p>A user may receive a dedicated <span class="term" data-term="crypto-exchanges/deposit-address">deposit address</span>, while the exchange may technically manage the assets through a larger address system or pooled wallet architecture. Once a <span class="term" data-term="blockchain/transaction">transaction</span> receives the required confirmations, the exchange can credit the corresponding internal balance.</p>

                <p>Exchanges may use hot and cold storage systems. Key management is a critical part of custody security because compromise of wallet infrastructure can result in asset loss. This also illustrates the distinction between custodial exchange storage and <span class="term" data-term="crypto-wallets/self-custody">self-custody</span>.</p>'
            ],

            'deposit' => [
                'title' => 'What Is a Crypto Exchange Deposit | TM Wiki',
                'description' => 'A deposit is the process of adding crypto assets or fiat funds to an exchange account for trading or other operations.',
                'name' => 'Deposit',
                'caption' => 'Adding funds to a cryptocurrency exchange.',
                'definition' => '<p>A <strong>deposit</strong> is an operation that adds funds to a crypto exchange account. Depending on the platform, a deposit may involve sending cryptocurrency to a provided <span class="term" data-term="crypto-exchanges/deposit-address">deposit address</span> or adding fiat currency through a supported payment method.</p>

                <p>For a cryptocurrency deposit, the user selects an asset and network and receives an address or another required identifier. The sender creates a <span class="term" data-term="blockchain/transaction">transaction</span>, which is eventually included in a <span class="term" data-term="blockchain/block">block</span>. After receiving the required number of confirmations, the exchange may credit the deposit.</p>

                <h3>What to verify before depositing</h3>
                <ul>
                    <li>the correct asset;</li>
                    <li>the supported network;</li>
                    <li>the destination address;</li>
                    <li>any required memo, tag, or additional identifier;</li>
                    <li>the minimum deposit amount.</li>
                </ul>

                <p>Sending an asset to an unsupported network or incorrect address can result in delayed or lost funds. Deposit details should therefore be checked immediately before sending.</p>'
            ],

            'deposit-address' => [
                'title' => 'What Is a Deposit Address | TM Wiki',
                'description' => 'A deposit address is a blockchain address provided by an exchange for depositing a specific crypto asset.',
                'name' => 'Deposit Address',
                'caption' => 'An address used to send cryptocurrency to an exchange.',
                'definition' => '<p>A <strong>deposit address</strong> is a <span class="term" data-term="crypto-wallets/wallet-address">wallet address</span> provided by a crypto exchange for receiving a particular <span class="term" data-term="cryptocurrency/crypto-asset">crypto asset</span>.</p>

                <p>The address is associated with a blockchain network or token standard. An address format alone does not guarantee that every asset can safely be sent through every network. Token deposits may require selecting the correct supported network, and some assets also require a memo or tag.</p>

                <p>After the transfer is broadcast, the exchange monitors the <span class="term" data-term="blockchain/blockchain">blockchain</span> for the relevant <span class="term" data-term="blockchain/transaction">transaction</span> and credits the user\'s internal balance after its deposit conditions are satisfied.</p>

                <p>The asset, network, and address should be verified before sending. Transfers through unsupported networks may require manual recovery or may become unrecoverable.</p>'
            ],

            'trading-fee' => [
                'title' => 'What Is a Trading Fee | TM Wiki',
                'description' => 'A trading fee is a charge applied by a crypto exchange for executing a trade or using its trading infrastructure.',
                'name' => 'Trading Fee',
                'caption' => 'The fee charged for executing a trading operation.',
                'definition' => '<p>A <strong>trading fee</strong> is a charge applied by a crypto exchange when a trading operation is executed. It is commonly calculated as a percentage of the trade value, although the exact fee model varies by platform.</p>

                <p>The fee may depend on the trading product, user volume, account tier, order type, and execution role. Exchange fee structures commonly distinguish between <span class="term" data-term="crypto-exchanges/maker">maker</span> fees and <span class="term" data-term="crypto-exchanges/taker">taker</span> fees.</p>

                <p>Trading fees directly affect the outcome of <span class="term" data-term="crypto-trading/crypto-trading">crypto trading</span>. For frequent trading, even a small percentage can become a significant cumulative cost when combined with <span class="term" data-term="crypto-trading/spread">spread</span> and <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>'
            ],

            'maker' => [
                'title' => 'What Is a Maker in Crypto Trading | TM Wiki',
                'description' => 'A maker is a market participant whose order adds liquidity to the order book instead of executing immediately.',
                'name' => 'Maker',
                'caption' => 'A participant who adds liquidity to the order book.',
                'definition' => '<p>A <strong>maker</strong> is a market participant whose order adds liquidity to an <span class="term" data-term="crypto-trading/order-book">order book</span>. The order normally does not execute immediately and remains available for a matching counter-order.</p>

                <p>Makers commonly use <span class="term" data-term="crypto-trading/limit-order">limit orders</span> to specify the price at which they are willing to buy or sell. If the order remains in the book and is later matched by another participant, the corresponding execution is classified as maker execution.</p>

                <p>Maker and <span class="term" data-term="crypto-exchanges/taker">taker</span> describe the role of a particular execution rather than a permanent account classification. The same trader can be a maker in one trade and a taker in another.</p>'
            ],

            'taker' => [
                'title' => 'What Is a Taker in Crypto Trading | TM Wiki',
                'description' => 'A taker is a market participant whose order immediately executes against existing liquidity in the order book.',
                'name' => 'Taker',
                'caption' => 'A participant who removes liquidity from the order book.',
                'definition' => '<p>A <strong>taker</strong> is a market participant whose order executes immediately against existing orders in an <span class="term" data-term="crypto-trading/order-book">order book</span>. This execution removes available liquidity at the relevant price levels.</p>

                <p>Market orders are normally executed as taker orders. A limit order can also receive taker classification if it immediately crosses the current <span class="term" data-term="crypto-trading/bid">bid</span> or <span class="term" data-term="crypto-trading/ask">ask</span>.</p>

                <p>A taker is normally charged a <span class="term" data-term="crypto-exchanges/taker">taker</span> fee. The effective trading cost can also depend on order size, market depth, and <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>'
            ],

            'order-matching' => [
                'title' => 'What Is Order Matching | TM Wiki',
                'description' => 'Order matching is the process of finding compatible buy and sell orders and executing them on an exchange.',
                'name' => 'Order Matching',
                'caption' => 'The process of matching buyers with sellers.',
                'definition' => '<p><strong>Order matching</strong> is the process of finding compatible buy and sell orders on a trading platform. On a centralized exchange, this process is normally performed by a <span class="term" data-term="crypto-exchanges/matching-engine">matching engine</span>.</p>

                <p>Orders are organized in an <span class="term" data-term="crypto-trading/order-book">order book</span> according to price and execution priority. Buyers submit <span class="term" data-term="crypto-trading/bid">bids</span>, while sellers submit <span class="term" data-term="crypto-trading/ask">asks</span>. When compatible conditions exist, the system creates a trade.</p>

                <h3>Execution priority</h3>
                <p>A common model prioritizes price first and time second. More competitive prices receive priority, while orders at the same price are commonly processed according to their placement time. Exact matching rules depend on the exchange.</p>'
            ],

            'matching-engine' => [
                'title' => 'What Is a Matching Engine | TM Wiki',
                'description' => 'A matching engine is exchange software that matches buy and sell orders and creates executed trades.',
                'name' => 'Matching Engine',
                'caption' => 'The software system that matches exchange orders.',
                'definition' => '<p>A <strong>matching engine</strong> is the software system used by an exchange to process trading orders and determine which buy and sell orders can execute against each other.</p>

                <p>The engine maintains the state of the <span class="term" data-term="crypto-trading/order-book">order book</span>, applies price and priority rules, and creates trades when compatible orders appear. Its performance affects processing latency, throughput, and the exchange’s ability to handle high <span class="term" data-term="crypto-trading/trading-volume">trading volume</span>.</p>

                <p>After a match occurs, the system updates order status and relevant account balances. In a centralized architecture, the matching engine is one of the core components of the exchange trading infrastructure.</p>'
            ],

            'kyc' => [
                'title' => 'What Is KYC in Crypto | TM Wiki',
                'description' => 'KYC is the process of identifying and verifying customers of a crypto exchange or other financial service.',
                'name' => 'KYC',
                'caption' => 'Customer identification and identity verification.',
                'definition' => '<p><strong>KYC</strong> (Know Your Customer) is the process of identifying and verifying a customer of a financial service. On centralized crypto exchanges, KYC may be required to access certain features, limits, or financial operations.</p>

                <p>The process may involve providing a name, date of birth, identity document, proof of address, and other information. Exact requirements depend on the jurisdiction and exchange policy.</p>

                <p>KYC is part of a broader compliance and risk-control framework and may be used together with <span class="term" data-term="crypto-exchanges/aml">AML</span>. The concepts are not identical: KYC primarily establishes customer identity, while AML covers broader measures for detecting and preventing money laundering and related financial risks.</p>'
            ],

            'aml' => [
                'title' => 'What Is AML in Crypto | TM Wiki',
                'description' => 'AML is a set of measures designed to prevent money laundering and detect suspicious financial activity.',
                'name' => 'AML',
                'caption' => 'Controls designed to prevent money laundering.',
                'definition' => '<p><strong>AML</strong> (Anti-Money Laundering) is a set of procedures and controls designed to prevent financial infrastructure from being used for money laundering and other illicit financial activity.</p>

                <p>On centralized crypto exchanges, AML controls may include transaction monitoring, source-of-funds analysis, detection of unusual activity, customer screening, and reporting or cooperation with authorities where legally required.</p>

                <p>AML is closely related to <span class="term" data-term="crypto-exchanges/kyc">KYC</span>, but the concepts are different. KYC focuses primarily on establishing and verifying customer identity, while AML covers a broader framework for monitoring and controlling financial activity.</p>'
            ],

            'proof-of-reserves' => [
                'title' => 'What Is Proof of Reserves | TM Wiki',
                'description' => 'Proof of Reserves is a method for demonstrating that a crypto exchange holds specified assets in reserve.',
                'name' => 'Proof of Reserves',
                'caption' => 'A method for demonstrating exchange asset reserves.',
                'definition' => '<p><strong>Proof of Reserves</strong> (PoR) is an approach in which a crypto exchange provides evidence that it controls specified assets in its reserves. The purpose is to improve transparency around the assets held by the exchange.</p>

                <p>Implementations may include publishing blockchain wallet addresses, cryptographic proofs of customer balances, or independent verification. Some systems use <span class="term" data-term="security/cryptographic-hash">cryptographic hashing</span> to demonstrate that information was included in an aggregated dataset without publicly exposing every underlying detail.</p>

                <p>Proof of Reserves is not automatically a complete assessment of an exchange’s financial condition. It may demonstrate the existence of certain assets without fully disclosing liabilities, debts, legal claims, or other balance-sheet elements. PoR should therefore be understood as a transparency mechanism rather than a universal guarantee of solvency.</p>'
            ],

            'exchange-liquidity' => [
                'title' => 'What Is Exchange Liquidity | TM Wiki',
                'description' => 'Exchange liquidity describes how much trading can occur without causing significant price movement.',
                'name' => 'Exchange Liquidity',
                'caption' => 'The ability to execute trades with limited price impact.',
                'definition' => '<p><strong>Exchange liquidity</strong> is the ability of a trading venue to facilitate purchases and sales of significant asset amounts without causing substantial price movement. Liquidity is created by market participants and can vary considerably between trading pairs.</p>

                <p>One of the main sources of information about liquidity is the <span class="term" data-term="crypto-trading/order-book">order book</span>. Its <span class="term" data-term="crypto-trading/market-depth">market depth</span> shows how much buy and sell liquidity is available at different price levels.</p>

                <p>High liquidity is generally associated with tighter <span class="term" data-term="crypto-trading/spread">spreads</span> and lower <span class="term" data-term="crypto-trading/slippage">slippage</span> for comparable trade sizes. However, liquidity can change rapidly during periods of high <span class="term" data-term="crypto-trading/volatility">volatility</span>.</p>

                <p>Liquidity should also be distinguished from <span class="term" data-term="crypto-trading/trading-volume">trading volume</span>. High volume indicates that a large amount of trading occurred during a period, but it does not by itself guarantee a deep order book or low price impact for large orders.</p>'
            ],
        ],
    ],

    'crypto-wallets' => [
        'title' => 'Crypto Wallet Terms',
        'description' => 'Crypto wallet glossary covering seed phrases, private keys, addresses, hot wallets, cold wallets and other terms.',
        'name' => 'Crypto Wallets',
        'caption' => 'Terms related to cryptocurrency wallets, including seed phrases, private and public keys, addresses, hot and cold wallets and other concepts.',
        'terms' => [
            'crypto-wallet' => [
                'title' => 'What Is a Crypto Wallet | TM Wiki',
                'description' => 'A crypto wallet is a tool for managing crypto assets, keys, and addresses used to receive and send funds.',
                'name' => 'Crypto Wallet',
                'caption' => 'A tool for managing crypto assets and keys.',
                'definition' => '<p>A <strong>crypto wallet</strong> is a software, hardware, or other tool that allows a user to manage crypto assets through the corresponding <span class="term" data-term="crypto-wallets/private-key">private keys</span> and create operations on a <span class="term" data-term="blockchain/blockchain">blockchain</span>. Unlike a traditional bank account, a wallet does not literally store coins or tokens inside the device. The assets remain recorded on the relevant blockchain, while the wallet provides the means to control them.</p>

                <p>Key wallet components include key material, <span class="term" data-term="crypto-wallets/wallet-address">addresses</span>, and software or hardware used to create and sign <span class="term" data-term="blockchain/transaction">transactions</span>. To send funds, the wallet constructs a transaction and uses <span class="term" data-term="crypto-wallets/transaction-signing">transaction signing</span> to prove control of the relevant key.</p>

                <h3>Main types of crypto wallets</h3>
                <ul>
                    <li><span class="term" data-term="crypto-wallets/hot-wallet">hot wallets</span> — connected to the network continuously or regularly;</li>
                    <li><span class="term" data-term="crypto-wallets/cold-wallet">cold wallets</span> — designed to keep key material away from continuously connected environments;</li>
                    <li><span class="term" data-term="crypto-wallets/hardware-wallet">hardware wallets</span> — use a dedicated physical device;</li>
                    <li><span class="term" data-term="crypto-wallets/software-wallet">software wallets</span> — operate through applications, browsers, or operating systems;</li>
                    <li><span class="term" data-term="crypto-wallets/custodial-wallet">custodial wallets</span> — keys are controlled by a third party;</li>
                    <li><span class="term" data-term="crypto-wallets/non-custodial-wallet">non-custodial wallets</span> — the user controls the keys.</li>
                </ul>

                <p>A wallet may support one or multiple blockchains and different types of assets, including <span class="term" data-term="cryptocurrency/coin">coins</span> and <span class="term" data-term="cryptocurrency/token">tokens</span>. Depending on its architecture, it may also interact with <span class="term" data-term="deFi/dapp">dApps</span>, smart contracts, <span class="term" data-term="deFi/defi">DeFi</span> protocols, and <span class="term" data-term="staking/staking">staking</span> systems.</p>

                <h3>What a wallet actually stores</h3>
                <p>Crypto assets are not physically stored in a wallet file or device. The blockchain contains the relevant state, while the wallet stores or accesses the secret information required to control those assets. Losing the key material can therefore result in loss of access even though the assets themselves remain recorded on the blockchain.</p>

                <p>Wallet security depends heavily on protecting the <span class="term" data-term="crypto-wallets/private-key">private key</span> or <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span>. If the key material is compromised, an attacker may be able to authorize transactions. Wallet security is therefore closely connected with <span class="term" data-term="security/private-key-security">private-key security</span>, backup, and recovery procedures.</p>'
            ],

            'hot-wallet' => [
                'title' => 'What Is a Hot Wallet | TM Wiki',
                'description' => 'A hot wallet is a crypto wallet connected to the internet and designed for regular access to crypto assets.',
                'name' => 'Hot Wallet',
                'caption' => 'A wallet connected to an online environment.',
                'definition' => '<p>A <strong>hot wallet</strong> is a crypto wallet that operates in an environment with internet access, allowing users to quickly receive, send, and sign operations involving crypto assets. Many mobile, desktop, and browser wallets are hot wallets.</p>

                <p>The main advantage of a hot wallet is convenience. Users can quickly generate a <span class="term" data-term="crypto-wallets/wallet-address">wallet address</span>, receive assets, sign a <span class="term" data-term="blockchain/transaction">transaction</span>, or connect to a <span class="term" data-term="deFi/dapp">dApp</span>. This makes hot wallets useful for regular transactions, trading, <span class="term" data-term="deFi/defi">DeFi</span>, and other activities that require frequent blockchain interaction.</p>

                <h3>Hot wallet risks</h3>
                <p>Continuous internet connectivity increases the attack surface. Malware, phishing websites, malicious browser extensions, fake applications, and other threats can target the device or wallet environment. If an attacker obtains key material or tricks the user into approving a malicious operation, assets can be lost.</p>

                <p>For this reason, hot wallets are often used for funds intended for active operations, while larger long-term holdings may be kept in a <span class="term" data-term="crypto-wallets/cold-wallet">cold wallet</span>. This separation does not eliminate risk, but it can reduce the amount of capital directly exposed to a continuously connected environment.</p>'
            ],

            'cold-wallet' => [
                'title' => 'What Is a Cold Wallet | TM Wiki',
                'description' => 'A cold wallet keeps key material largely offline to reduce the risk of remote compromise.',
                'name' => 'Cold Wallet',
                'caption' => 'A wallet designed to keep keys away from online environments.',
                'definition' => '<p>A <strong>cold wallet</strong> is a method of storing cryptographic keys in which the key material is generally kept outside a continuously internet-connected environment. The main purpose of cold storage is to reduce the likelihood of remote access to <span class="term" data-term="crypto-wallets/private-key">private keys</span>.</p>

                <p>Cold storage can be implemented through a <span class="term" data-term="crypto-wallets/hardware-wallet">hardware wallet</span>, an isolated computer, an offline device, or other procedures designed to separate keys from ordinary online environments. A cold wallet therefore describes a storage and access model rather than one specific device type.</p>

                <h3>Cold versus hot storage</h3>
                <p>A <span class="term" data-term="crypto-wallets/hot-wallet">hot wallet</span> emphasizes convenience and frequent network interaction, while cold storage emphasizes isolation of key material. Cold storage generally requires additional steps when signing transactions and is therefore less convenient for frequent activity.</p>

                <p>Cold storage does not automatically protect against every threat. Users must still protect their <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span>, backups, and devices. They must also verify transaction details before <span class="term" data-term="crypto-wallets/transaction-signing">signing</span>, because physical key isolation does not prevent social engineering or accidental approval of malicious operations.</p>'
            ],

            'hardware-wallet' => [
                'title' => 'What Is a Hardware Wallet | TM Wiki',
                'description' => 'A hardware wallet is a physical device designed to protect private keys and sign cryptocurrency transactions.',
                'name' => 'Hardware Wallet',
                'caption' => 'A physical device for protecting cryptographic keys.',
                'definition' => '<p>A <strong>hardware wallet</strong> is a specialized physical device designed to store or use <span class="term" data-term="crypto-wallets/private-key">private keys</span> and perform <span class="term" data-term="crypto-wallets/transaction-signing">transaction signing</span>. Its purpose is to separate sensitive key material from the normal operating environment of a computer or smartphone.</p>

                <p>When a transaction is initiated, the companion application sends the required transaction data to the device. The hardware wallet uses the protected key to generate a digital signature and returns the signed transaction to the application, which can then broadcast it to the <span class="term" data-term="blockchain/blockchain">blockchain</span>. In a properly designed architecture, the private key does not leave the device.</p>

                <h3>Why hardware wallets are used</h3>
                <ul>
                    <li>to isolate private keys from the normal operating system;</li>
                    <li>to approve sensitive operations on a separate device;</li>
                    <li>to reduce exposure to key-stealing malware;</li>
                    <li>to support long-term crypto asset storage;</li>
                    <li>to manage multiple blockchains and assets.</li>
                </ul>

                <p>A hardware wallet does not eliminate the need to protect the <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span>. If the recovery phrase is exposed, device security may no longer protect the associated assets. Users should also verify addresses and transaction details on the device before approving a signature.</p>'
            ],

            'software-wallet' => [
                'title' => 'What Is a Software Wallet | TM Wiki',
                'description' => 'A software wallet is an application used to manage keys, addresses, and transactions involving crypto assets.',
                'name' => 'Software Wallet',
                'caption' => 'An application for managing crypto assets and keys.',
                'definition' => '<p>A <strong>software wallet</strong> is an application, browser extension, or other software program used to manage <span class="term" data-term="crypto-wallets/private-key">private keys</span>, create <span class="term" data-term="crypto-wallets/wallet-address">addresses</span>, and sign <span class="term" data-term="blockchain/transaction">transactions</span>.</p>

                <p>A software wallet may run on a desktop computer, smartphone, or browser. It may be <span class="term" data-term="crypto-wallets/hot-wallet">hot</span> when its keys are used in an internet-connected environment, and it may be <span class="term" data-term="crypto-wallets/non-custodial-wallet">non-custodial</span> when the user controls the key material directly.</p>

                <p>Depending on its implementation, a software wallet may support multiple networks, tokens, <span class="term" data-term="deFi/dapp">dApps</span>, and <span class="term" data-term="blockchain/smart-contract">smart contracts</span>. Some wallets also provide built-in asset swaps, <span class="term" data-term="staking/staking">staking</span>, and other functions.</p>

                <p>The main security risks of software wallets are connected with the security of the device and application environment. Malware, phishing, malicious extensions, and exposure of the <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span> can compromise assets. Wallet security therefore depends not only on the application itself but also on the entire environment in which it operates.</p>'
            ],

            'custodial-wallet' => [
                'title' => 'What Is a Custodial Wallet | TM Wiki',
                'description' => 'A custodial wallet is a wallet where private keys are controlled by a third party such as a crypto exchange.',
                'name' => 'Custodial Wallet',
                'caption' => 'A wallet where a third party controls the keys.',
                'definition' => '<p>A <strong>custodial wallet</strong> is a storage model in which <span class="term" data-term="crypto-wallets/private-key">private keys</span> are controlled by a third party, such as a crypto exchange, payment service, or other custodian.</p>

                <p>The user normally receives an account and sees a balance but does not necessarily receive direct access to the keys used to sign blockchain transactions. As a result, an internal transfer between users of the same platform may be only an internal ledger operation, while an actual <span class="term" data-term="blockchain/transaction">blockchain transaction</span> occurs when assets are deposited, withdrawn, or otherwise moved on-chain.</p>

                <h3>Characteristics of custodial storage</h3>
                <p>Custodial systems can simplify account recovery, account management, and access to exchange services. However, the user depends on the security, infrastructure, and policies of the custodian. Withdrawals may be restricted or delayed, and access can be affected by account controls or platform policies.</p>

                <p>The alternative model is a <span class="term" data-term="crypto-wallets/non-custodial-wallet">non-custodial wallet</span>, where the user controls the keys. The key distinction between the two models is therefore who controls the cryptographic keys rather than the appearance of the wallet application.</p>'
            ],

            'non-custodial-wallet' => [
                'title' => 'What Is a Non-Custodial Wallet | TM Wiki',
                'description' => 'A non-custodial wallet lets users control their private keys and authorize blockchain transactions themselves.',
                'name' => 'Non-Custodial Wallet',
                'caption' => 'A wallet where the user controls the keys.',
                'definition' => '<p>A <strong>non-custodial wallet</strong> is a wallet in which the user directly controls the <span class="term" data-term="crypto-wallets/private-key">private keys</span> required to manage assets. A third party should not have unilateral authority to sign transactions on the user’s behalf.</p>

                <p>When a wallet is created, it may generate a <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span> from which keys and <span class="term" data-term="crypto-wallets/wallet-address">addresses</span> can later be derived. The user is responsible for protecting this key material. If the key is lost and no backup exists, there may be no centralized recovery service.</p>

                <p>Non-custodial wallets can interact directly with <span class="term" data-term="deFi/defi">DeFi</span>, <span class="term" data-term="deFi/dapp">dApps</span>, and <span class="term" data-term="blockchain/smart-contract">smart contracts</span>. At the same time, they place greater responsibility on the user because compromised keys or malicious signatures can directly affect the assets.</p>'
            ],

            'self-custody' => [
                'title' => 'What Is Self-Custody in Crypto | TM Wiki',
                'description' => 'Self-custody means personally controlling and protecting the private keys associated with crypto assets.',
                'name' => 'Self-Custody',
                'caption' => 'Direct personal control over cryptocurrency keys.',
                'definition' => '<p><strong>Self-custody</strong> is a model of crypto asset ownership in which the user directly controls the <span class="term" data-term="crypto-wallets/private-key">private keys</span> required to manage the assets. The keys are not entrusted to a crypto exchange, custodian, or other intermediary.</p>

                <p>Self-custody can be implemented through a <span class="term" data-term="crypto-wallets/software-wallet">software wallet</span> or <span class="term" data-term="crypto-wallets/hardware-wallet">hardware wallet</span>. In both cases, the key material remains under the user’s control and transactions are authorized through <span class="term" data-term="crypto-wallets/transaction-signing">cryptographic signatures</span>.</p>

                <h3>User responsibility in self-custody</h3>
                <p>The user is responsible for backup procedures, <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span> security, device security, and transaction verification. Loss of a key, exposure of the recovery phrase, or approval of a malicious transaction can result in irreversible loss of assets.</p>

                <p>Self-custody therefore changes the trust model: the user relies less on a custodian but assumes more technical and operational responsibility for asset security and recovery.</p>'
            ],

            'private-key' => [
                'title' => 'What Is a Private Key | TM Wiki',
                'description' => 'A private key is secret cryptographic data used to sign transactions and control associated crypto assets.',
                'name' => 'Private Key',
                'caption' => 'A secret key used to control crypto assets.',
                'definition' => '<p>A <strong>private key</strong> is a secret cryptographic value used to create <span class="term" data-term="security/digital-signature">digital signatures</span> and authorize specific operations. In cryptocurrency systems, control over the corresponding private key generally means control over assets that can be spent or moved from associated addresses.</p>

                <p>A private key is mathematically related to a <span class="term" data-term="crypto-wallets/public-key">public key</span>. The public key can be used to verify signatures, while the private key must remain secret. Users should never disclose private keys or enter them into untrusted websites or applications.</p>

                <h3>Private keys and blockchains</h3>
                <p>The private key itself is normally not stored on the <span class="term" data-term="blockchain/blockchain">blockchain</span>. Instead, the blockchain contains information that allows the network to verify signatures or determine the state associated with an address. When funds are sent, the wallet uses the private key to create a signature that the network verifies.</p>

                <p>Modern wallets often do not require users to manage a separate private key for every address. In <span class="term" data-term="crypto-wallets/hd-wallet">HD wallets</span>, many keys can be derived from common root key material such as a seed phrase.</p>

                <p>Private-key security is critical. Disclosure can allow another person to authorize valid transactions, while loss of the key without a usable backup can make the associated assets inaccessible.</p>'
            ],

            'public-key' => [
                'title' => 'What Is a Public Key | TM Wiki',
                'description' => 'A public key is the public part of a cryptographic key pair used to verify digital signatures.',
                'name' => 'Public Key',
                'caption' => 'An open cryptographic key used to verify signatures.',
                'definition' => '<p>A <strong>public key</strong> is the public part of a cryptographic key pair and is mathematically related to the corresponding <span class="term" data-term="crypto-wallets/private-key">private key</span>. In digital-signature systems, the public key is used to verify that a signature was produced by the corresponding private key.</p>

                <p>In some blockchain systems, a <span class="term" data-term="crypto-wallets/wallet-address">wallet address</span> is derived directly or indirectly from a public key. However, a public key and an address are not universally interchangeable concepts: the exact address construction depends on the blockchain protocol and address standard.</p>

                <p>Unlike a private key, a public key is not intended to remain secret. Revealing it does not by itself allow someone to sign transactions. The security model relies on the computational difficulty of deriving the private key from the public key.</p>'
            ],

            'seed-phrase' => [
                'title' => 'What Is a Seed Phrase | TM Wiki',
                'description' => 'A seed phrase is a sequence of words used to restore a crypto wallet and its associated cryptographic keys.',
                'name' => 'Seed Phrase',
                'caption' => 'A recovery phrase used to restore a crypto wallet.',
                'definition' => '<p>A <strong>seed phrase</strong> is a sequence of words from which a compatible crypto wallet can restore its root key material and derived addresses. It provides a human-readable representation of secret information used by many <span class="term" data-term="crypto-wallets/hd-wallet">HD wallets</span>.</p>

                <p>One of the best-known standards for generating such phrases is BIP-39, although exact formats and recovery mechanisms depend on the wallet implementation. A seed phrase is not simply an application password: when supported by the relevant wallet standard, it can contain enough information to recreate the wallet’s key hierarchy.</p>

                <h3>Why a seed phrase is critical</h3>
                <p>Anyone who obtains the complete seed phrase may potentially restore the corresponding wallet on another device. It should therefore not be sent through messaging applications, stored in ordinary cloud documents, or entered into unknown websites.</p>

                <p>A seed phrase should have a backup that is protected against accidental deletion, device loss, and physical damage. The backup itself is a highly sensitive object because its compromise can be equivalent to compromise of the wallet keys. Seed-phrase protection is therefore a separate aspect of <span class="term" data-term="security/seed-phrase-security">wallet security</span>.</p>'
            ],

            'mnemonic-phrase' => [
                'title' => 'What Is a Mnemonic Phrase | TM Wiki',
                'description' => 'A mnemonic phrase is a sequence of words that represents cryptographic entropy used to recover wallet keys.',
                'name' => 'Mnemonic Phrase',
                'caption' => 'A human-readable representation of wallet key material.',
                'definition' => '<p>A <strong>mnemonic phrase</strong> is a sequence of words used to represent cryptographic entropy in a human-readable form. In compatible wallet systems, the phrase can be converted into the initial key material from which wallet keys and addresses are derived.</p>

                <p>In everyday usage, the terms <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span> and mnemonic phrase are often treated as synonyms, although technical terminology can vary by standard. For example, BIP-39 defines a mnemonic sentence that encodes entropy and a checksum and can then be converted into a seed.</p>

                <h3>Relationship to HD wallets</h3>
                <p>After recovering the root seed, the wallet can use a <span class="term" data-term="crypto-wallets/derivation-path">derivation path</span> to generate different branches of keys and addresses. As a result, one mnemonic phrase can correspond to many addresses and accounts.</p>

                <p>A mnemonic phrase must be treated as secret key material. Exposure can allow recovery of the corresponding keys, while loss without another backup can result in permanent loss of access to assets.</p>'
            ],

            'wallet-address' => [
                'title' => 'What Is a Crypto Wallet Address | TM Wiki',
                'description' => 'A crypto wallet address is an identifier used by a blockchain network to specify where crypto assets should be sent.',
                'name' => 'Wallet Address',
                'caption' => 'An identifier used to receive crypto assets.',
                'definition' => '<p>A <strong>crypto wallet address</strong> is an identifier used by a blockchain network or protocol to specify the recipient of a transfer. A sender uses the address when creating a <span class="term" data-term="blockchain/transaction">transaction</span> that transfers assets to the recipient.</p>

                <p>Address formats depend on the specific <span class="term" data-term="blockchain/blockchain">blockchain</span> and address standard. Some networks support multiple address formats for different use cases, while tokens may exist on several networks and use different contract addresses and interaction standards.</p>

                <p>An address can normally be shared publicly for receiving funds. It should not be confused with a <span class="term" data-term="crypto-wallets/private-key">private key</span>: the address identifies a destination, while the private key is used to authorize spending or other operations.</p>

                <h3>Address verification</h3>
                <p>Before sending funds, the complete destination address and network should be verified. Malware can replace copied addresses in a clipboard, so checking only the first and last characters is not sufficient protection.</p>'
            ],

            'change-address' => [
                'title' => 'What Is a Change Address | TM Wiki',
                'description' => 'A change address is an additional wallet address used to receive leftover funds from certain blockchain transactions.',
                'name' => 'Change Address',
                'caption' => 'An address used to receive transaction change.',
                'definition' => '<p>A <strong>change address</strong> is an address used by a wallet to receive the portion of funds that remains unspent in a <span class="term" data-term="blockchain/transaction">transaction</span>. The concept is especially associated with the <span class="term" data-term="blockchain/transaction-input">UTXO model</span> used by Bitcoin and similar systems.</p>

                <p>If transaction inputs contain more value than is needed for the recipient and the <span class="term" data-term="blockchain/transaction-fee">transaction fee</span>, the remainder is normally returned to the sender through another output. The wallet can automatically create a new change address for this purpose.</p>

                <h3>Why separate change addresses are used</h3>
                <p>Using new addresses allows wallets to manage multiple UTXOs and can improve privacy because not all transactions have to be associated with a single repeatedly used address.</p>

                <p>In <span class="term" data-term="crypto-wallets/hd-wallet">HD wallets</span>, change addresses are normally generated deterministically from common key material. When the wallet is restored using the correct <span class="term" data-term="crypto-wallets/derivation-path">derivation path</span>, it can therefore regenerate the relevant addresses.</p>'
            ],

            'hd-wallet' => [
                'title' => 'What Is an HD Wallet | TM Wiki',
                'description' => 'An HD wallet derives many cryptographic keys and addresses from a single root secret through a hierarchical structure.',
                'name' => 'HD Wallet',
                'caption' => 'A hierarchical deterministic cryptocurrency wallet.',
                'definition' => '<p>An <strong>HD wallet</strong> (Hierarchical Deterministic Wallet) is a wallet capable of deterministically generating many cryptographic keys and addresses from a single root secret. This architecture allows users to manage large numbers of addresses without separately backing up every individual key.</p>

                <p>The root material may be represented by a <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span>. The wallet derives a root key and then creates a hierarchy of child keys. The exact hierarchy is determined by the standards and <span class="term" data-term="crypto-wallets/derivation-path">derivation path</span> used by the wallet.</p>

                <h3>Advantages of HD wallets</h3>
                <ul>
                    <li>a single backup can restore many addresses;</li>
                    <li>new addresses can be generated deterministically;</li>
                    <li>addresses can be separated into accounts and usage branches;</li>
                    <li>dedicated branches can be used for change addresses;</li>
                    <li>wallet migration can be simplified when compatible standards are supported.</li>
                </ul>

                <p>HD architecture does not automatically make a wallet secure. Protection of the seed phrase and root key material remains critical. Recovery can also depend on the correct derivation path, account type, and wallet standard.</p>'
            ],

            'derivation-path' => [
                'title' => 'What Is a Derivation Path | TM Wiki',
                'description' => 'A derivation path determines which keys and addresses an HD wallet derives from its root seed.',
                'name' => 'Derivation Path',
                'caption' => 'The path used to derive keys and addresses in an HD wallet.',
                'definition' => '<p>A <strong>derivation path</strong> is a structure that determines which child keys an <span class="term" data-term="crypto-wallets/hd-wallet">HD wallet</span> derives from its root key material. A single seed can generate many different keys, and the derivation path selects a specific branch of that hierarchy.</p>

                <p>BIP-32 provides a widely used framework for hierarchical deterministic derivation, while account and address schemes may use additional standards such as BIP-44. A path can contain levels corresponding to purpose, coin type, account, chain, and address index.</p>

                <h3>Why the path matters during recovery</h3>
                <p>If a user restores a wallet from a <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span> but selects a different derivation path, the application may display an empty balance even though the original assets remain on the blockchain. The issue may therefore be the derivation branch rather than the seed itself.</p>

                <p>Wallet migration should account for the standard, account type, and derivation path used by the original wallet. Seed compatibility alone does not guarantee that every previously used address will be discovered automatically.</p>'
            ],

            'multisig' => [
                'title' => 'What Is a Multisig Wallet | TM Wiki',
                'description' => 'Multisig requires multiple independent cryptographic signatures before an operation can be authorized.',
                'name' => 'Multisig',
                'caption' => 'A wallet requiring multiple keys to approve transactions.',
                'definition' => '<p><strong>Multisig</strong> (multisignature) is a mechanism in which an operation requires multiple independent <span class="term" data-term="security/digital-signature">digital signatures</span>. Instead of relying on one private key, the system uses multiple authorized keys and a rule specifying how many signatures are required.</p>

                <p>For example, a 2-of-3 configuration has three authorized keys, but any two can approve an operation. This allows control to be distributed among multiple people, devices, or organizations.</p>

                <h3>Common multisig use cases</h3>
                <ul>
                    <li>joint management of corporate reserves;</li>
                    <li>crypto project treasuries;</li>
                    <li>protection of large crypto asset holdings;</li>
                    <li>reducing dependence on one device or person;</li>
                    <li>creating internal transaction approval procedures.</li>
                </ul>

                <p>Multisig can reduce the impact of compromise of a single key, but it introduces additional operational complexity. Multiple keys must be securely stored, the signing process must be coordinated, and a recovery plan must exist. Depending on the blockchain, multisig can be implemented at the protocol level, through specialized scripts, or with <span class="term" data-term="blockchain/smart-contract">smart contracts</span>.</p>'
            ],

            'transaction-signing' => [
                'title' => 'What Is Transaction Signing | TM Wiki',
                'description' => 'Transaction signing is the cryptographic authorization of a blockchain operation using a private key.',
                'name' => 'Transaction Signing',
                'caption' => 'Cryptographic authorization of a blockchain transaction.',
                'definition' => '<p><strong>Transaction signing</strong> is a cryptographic operation in which the holder of a corresponding <span class="term" data-term="crypto-wallets/private-key">private key</span> authorizes a specific operation. The network uses the relevant <span class="term" data-term="crypto-wallets/public-key">public key</span> or related cryptographic data to verify the signature.</p>

                <p>When sending funds, the wallet constructs a <span class="term" data-term="blockchain/transaction">transaction</span> containing the recipient, amount, fees, and other parameters required by the blockchain. The wallet then signs the transaction with the private key. The signed transaction can be broadcast to the network and may enter the <span class="term" data-term="blockchain/mempool">mempool</span> before being included in a <span class="term" data-term="blockchain/block">block</span>.</p>

                <h3>What a transaction signature proves</h3>
                <p>A digital signature allows the network to verify that the operation was authorized by the holder of the corresponding key and that the signed data has not been altered after signing. A signature does not, however, guarantee that a transaction will be included in the blockchain: it must still satisfy the network rules and may remain pending or be rejected.</p>

                <p>It is also important to distinguish cryptographic signing from simply clicking a confirmation button in a wallet interface. Signing authorizes a specific operation, so the user should verify the recipient, amount, fee, and other parameters before approval. This is especially important when interacting with <span class="term" data-term="deFi/dapp">dApps</span> and <span class="term" data-term="blockchain/smart-contract">smart contracts</span>, where the signed action may be more complex than a simple transfer.</p>'
            ],
        ],
    ],

    'defi' => [
        'title' => 'DeFi and Decentralized Finance Terms',
        'description' => 'DeFi glossary covering DEX, AMM, liquidity pools, yield farming, TVL, impermanent loss and other terms.',
        'name' => 'DeFi',
        'caption' => 'Terms related to decentralized finance, including DEX, AMM, liquidity pools, yield farming, TVL, impermanent loss and other concepts.',
        'terms' => [
            'defi' => [
                'title' => 'What Is DeFi | TM Wiki',
                'description' => 'DeFi is a set of blockchain-based financial services that operate without traditional centralized intermediaries.',
                'name' => 'DeFi',
                'caption' => 'Decentralized finance on blockchain',
                'definition' => '<p><strong>DeFi (Decentralized Finance)</strong> is a broad ecosystem of financial applications, protocols, and services built on <span class="term" data-term="blockchain/blockchain">blockchains</span> that allow users to perform financial operations without relying on a traditional centralized intermediary. Instead of a bank, broker, or financial company controlling the operation, part of the financial logic is implemented through <span class="term" data-term="blockchain/smart-contract">smart contracts</span>, blockchain consensus, and cryptographic authorization.</p>

                <p>Users normally interact with a DeFi protocol through a <span class="term" data-term="defi/dapp">dApp</span> and a <span class="term" data-term="crypto-wallets/crypto-wallet">crypto wallet</span>. The wallet allows the user to control assets and authorize operations by signing blockchain transactions. Depending on the protocol, users can exchange assets, lend them, borrow against collateral, provide liquidity, or participate in governance.</p>

                <p>Major DeFi components include <span class="term" data-term="defi/liquidity-pool">liquidity pools</span>, <span class="term" data-term="defi/automated-market-maker">automated market makers</span>, lending protocols, yield strategies, and <span class="term" data-term="defi/oracle">oracles</span>. Protocol governance may be organized through a <span class="term" data-term="defi/dao">DAO</span>.</p>

                <p>DeFi is not necessarily completely decentralized in every implementation. A protocol may depend on centralized interfaces, external data providers, administrative keys, upgrade mechanisms, or infrastructure providers. Therefore, the actual level of decentralization must be evaluated for each protocol separately.</p>

                <p>A major characteristic of DeFi is composability. One protocol can interact with another through smart contracts, allowing financial operations to be combined into more complex strategies. For example, a user can borrow an asset from one protocol and use it in another protocol for trading or liquidity provision.</p>

                <p>DeFi also introduces significant risks. Smart-contract vulnerabilities, oracle failures, liquidity shortages, market volatility, governance attacks, phishing, and user mistakes can result in losses. Therefore, DeFi should be understood as programmable financial infrastructure rather than as an automatically safe replacement for traditional finance.</p>'
            ],

            'decentralized-finance' => [
                'title' => 'What Is Decentralized Finance | TM Wiki',
                'description' => 'Decentralized finance uses blockchains and smart contracts to provide financial services without traditional intermediaries.',
                'name' => 'Decentralized Finance',
                'caption' => 'Financial services without traditional intermediaries',
                'definition' => '<p><strong>Decentralized finance</strong> is a financial model in which financial operations and rules are implemented using <span class="term" data-term="blockchain/blockchain">blockchains</span>, <span class="term" data-term="blockchain/smart-contract">smart contracts</span>, and cryptographic authorization. Instead of relying entirely on a bank or centralized financial company, users interact directly with software protocols.</p>

                <p>Traditional finance normally requires an organization to maintain records, custody assets, approve transactions, or enforce contractual rules. In decentralized finance, some of these functions are transferred to software deployed on a blockchain. For example, a <span class="term" data-term="defi/decentralized-lending">decentralized lending</span> protocol can automatically accept collateral, calculate borrowing capacity, and initiate liquidation when predefined conditions are reached.</p>

                <p>A typical DeFi application provides a <span class="term" data-term="defi/dapp">dApp</span> interface through which users interact with smart contracts. The interface displays information and constructs transaction data, while the blockchain and smart contracts perform the actual state changes.</p>

                <p>Decentralized finance includes asset swaps, liquidity provision, lending, borrowing, yield strategies, derivatives, and governance systems. Many of these applications depend on external market information supplied through <span class="term" data-term="defi/price-oracle">price oracles</span>.</p>

                <p>Decentralization can exist at several different layers. The smart contracts may be publicly deployed while governance, interfaces, oracle infrastructure, or upgrade permissions remain concentrated. Therefore, the term describes an architectural approach rather than guaranteeing that every component is decentralized.</p>

                <p>One of the defining properties of decentralized finance is composability. Protocols can interact with one another programmatically, allowing users and developers to construct financial applications from reusable components. This increases functionality but also creates interconnected risks because a failure in one protocol can affect other protocols that depend on it.</p>'
            ],

            'dapp' => [
                'title' => 'What Is a dApp | TM Wiki',
                'description' => 'A dApp is a decentralized application that interacts with blockchain networks and smart contracts.',
                'name' => 'dApp',
                'caption' => 'Decentralized blockchain application',
                'definition' => '<p>A <strong>dApp</strong>, or decentralized application, is an application that uses a <span class="term" data-term="blockchain/blockchain">blockchain</span> and one or more <span class="term" data-term="blockchain/smart-contract">smart contracts</span> to implement part of its functionality. In DeFi, a dApp commonly provides the user interface through which users interact with a financial protocol.</p>

                <p>A typical dApp consists of a frontend interface and blockchain-connected logic. The frontend can be a conventional web application displaying balances, prices, liquidity, and transaction parameters. When the user performs an action, the application constructs a blockchain transaction that is then authorized through a <span class="term" data-term="crypto-wallets/crypto-wallet">crypto wallet</span>.</p>

                <p>After <span class="term" data-term="crypto-wallets/transaction-signing">transaction signing</span>, the transaction can be broadcast to the network. <span class="term" data-term="blockchain/blockchain-node">Blockchain nodes</span> process it and the relevant smart contract executes the programmed logic.</p>

                <p>A dApp can interact with several contracts in one operation. For example, a decentralized exchange interface can interact with routing contracts, liquidity pools, token contracts, and other components. One user action can therefore result in multiple contract calls within a single blockchain transaction.</p>

                <p>The presence of a dApp interface does not automatically mean that the entire system is decentralized. The frontend may be hosted on centralized infrastructure, data may come from centralized APIs, and contract upgrades may be controlled by a limited group.</p>

                <p>dApp risks include smart-contract vulnerabilities, malicious interfaces, phishing, incorrect token approvals, compromised wallets, and user mistakes. Users should verify contract addresses, supported networks, permissions, and the identity of the protocol before signing transactions.</p>'
            ],

            'liquidity-pool' => [
                'title' => 'What Is a Liquidity Pool | TM Wiki',
                'description' => 'A liquidity pool is a smart-contract-controlled reserve of assets used by DeFi protocols for trading and other financial operations.',
                'name' => 'Liquidity Pool',
                'caption' => 'On-chain reserve used by DeFi protocols',
                'definition' => '<p>A <strong>liquidity pool</strong> is a reserve of cryptoassets locked in a <span class="term" data-term="blockchain/smart-contract">smart contract</span> and used by a DeFi protocol to facilitate financial operations. One of the most common applications is decentralized token trading, where a pool provides liquidity without requiring a traditional <span class="term" data-term="crypto-trading/order-book">order book</span>.</p>

                <p>Users who deposit assets into a pool are called <span class="term" data-term="defi/liquidity-provider">liquidity providers</span>. Depending on the protocol, they receive a share of the pool and may earn a portion of transaction fees. The exact accounting mechanism differs between protocols.</p>

                <p>For example, a pool can contain Token A and Token B. A trader exchanging Token A for Token B interacts with the pool contract. The transaction increases the reserve of Token A and decreases the reserve of Token B according to the pool formula and the amount being traded.</p>

                <p>Pool size has a major effect on trading quality. A large amount of liquidity relative to the trade size generally reduces the price impact of a transaction. A small pool can experience significant reserve changes from a large trade, resulting in higher <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <p>Liquidity pools are not limited to token swaps. They can also be used as components of lending markets, derivatives, yield strategies, and other financial applications. In lending systems, for example, deposited assets can form a shared reserve from which borrowers obtain liquidity.</p>

                <p>Liquidity providers take on several risks. One of the most important is <span class="term" data-term="defi/impermanent-loss">impermanent loss</span>, which can occur when the relative prices of pool assets change. Smart-contract vulnerabilities, oracle failures, liquidity shortages, and protocol-specific economic risks also need to be considered.</p>

                <h3>Important liquidity-pool metrics</h3>

                <ul>
                    <li><strong>Reserves</strong> — amounts of each asset held by the pool.</li>
                    <li><strong>Trading volume</strong> — value or quantity of trades executed through the pool.</li>
                    <li><strong>Fees</strong> — charges collected from users and potentially distributed to liquidity providers.</li>
                    <li><strong>Liquidity share</strong> — the provider share of the pool.</li>
                    <li><strong>Price impact</strong> — the effect of a trade on the effective execution price.</li>
                </ul>'
            ],

            'liquidity-provider' => [
                'title' => 'What Is a Liquidity Provider | TM Wiki',
                'description' => 'A liquidity provider deposits assets into a DeFi liquidity pool and may earn fees or other rewards in return.',
                'name' => 'Liquidity Provider',
                'caption' => 'Participant providing liquidity to a protocol',
                'definition' => '<p>A <strong>liquidity provider</strong>, or LP, is a user or organization that deposits cryptoassets into a <span class="term" data-term="defi/liquidity-pool">liquidity pool</span>. The deposited assets are then used by a DeFi protocol to support swaps, lending, or other operations.</p>

                <p>In a typical AMM pool, the provider deposits two or more assets according to the pool requirements. The provider receives a proportional claim on the pool or a specific liquidity position. This position may entitle the provider to a share of transaction fees.</p>

                <p>Liquidity-provider returns can come from trading fees and, in some protocols, additional incentives. However, the displayed yield does not represent guaranteed profit. The final result depends on fees, asset-price changes, token incentives, costs, and the risks of the underlying protocol.</p>

                <p>The most important market-specific risk is <span class="term" data-term="defi/impermanent-loss">impermanent loss</span>. When the relative price of pool assets changes, the composition of the provider position changes because traders arbitrage the pool against external markets.</p>

                <p>Some protocols issue special liquidity tokens representing the provider position. These tokens may themselves be deposited into another protocol as part of <span class="term" data-term="defi/yield-farming">yield farming</span>. Other protocols represent liquidity positions directly through smart contracts.</p>

                <p>Before providing liquidity, users should examine pool composition, fees, withdrawal rules, incentives, contract security, market liquidity, and the potential effect of asset-price changes. A high advertised APY does not remove these risks.</p>'
            ],

            'automated-market-maker' => [
                'title' => 'What Is an AMM | TM Wiki',
                'description' => 'An AMM is an automated market maker that determines trading conditions using mathematical formulas and liquidity pools.',
                'name' => 'Automated Market Maker',
                'caption' => 'Algorithmic liquidity and price discovery',
                'definition' => '<p>An <strong>automated market maker</strong>, or AMM, is a mechanism for decentralized trading that uses liquidity pools and mathematical formulas instead of a traditional <span class="term" data-term="crypto-trading/order-book">order book</span> where buyers and sellers submit individual orders.</p>

                <p>In a typical AMM, a <span class="term" data-term="defi/liquidity-pool">liquidity pool</span> holds reserves of multiple assets. A trader interacts with a smart contract rather than directly matching with a specific counterparty. The contract changes the reserves according to the mathematical model used by the protocol.</p>

                <p>One well-known model is based on a constant-product relationship. In simplified form, it can be represented as <code>x * y = k</code>, where <code>x</code> and <code>y</code> represent the reserves of two assets. The exact implementation also accounts for fees and protocol-specific rules.</p>

                <p>Because the reserves change after every trade, the execution price depends on the size of the transaction relative to available liquidity. A large transaction can move the pool price substantially and create higher <span class="term" data-term="crypto-trading/slippage">slippage</span>.</p>

                <p>Liquidity is supplied by <span class="term" data-term="defi/liquidity-provider">liquidity providers</span>. They deposit assets into the pool and may receive a portion of trading fees. In return, they accept market and smart-contract risks, including <span class="term" data-term="defi/impermanent-loss">impermanent loss</span>.</p>

                <p>Different AMM designs use different mathematical curves and liquidity models. Some are optimized for volatile assets, while others are designed for assets whose prices normally remain close to one another, such as certain stablecoins.</p>

                <p>An AMM therefore combines a pricing mechanism, a liquidity mechanism, and an incentive system. External arbitrage traders help align pool prices with broader markets, while liquidity providers supply the capital required for continuous trading.</p>'
            ],

            'yield-farming' => [
                'title' => 'What Is Yield Farming | TM Wiki',
                'description' => 'Yield farming is the use of DeFi strategies to generate returns by deploying cryptoassets across protocols.',
                'name' => 'Yield Farming',
                'caption' => 'Strategies for generating DeFi yield',
                'definition' => '<p><strong>Yield farming</strong> is the use of one or more DeFi strategies to generate returns from cryptoassets. A user may provide liquidity, lend assets, receive protocol incentives, stake positions, or move capital between protocols in pursuit of a higher expected return.</p>

                <p>A simple yield-farming strategy can begin with depositing assets into a <span class="term" data-term="defi/liquidity-pool">liquidity pool</span>. The user may receive trading fees and additional protocol rewards. Those rewards can potentially be reinvested to increase the position.</p>

                <p>More complex strategies can combine multiple protocols. For example, a user can deposit an asset into a <span class="term" data-term="defi/lending-protocol">lending protocol</span>, receive an interest-bearing position, and use that position elsewhere. Automated strategies can repeatedly reinvest rewards or rebalance capital.</p>

                <p>Yield-farming returns are not guaranteed. APY and APR can change rapidly as capital enters or leaves a pool, trading activity changes, or token-emission schedules evolve. A high displayed yield can therefore decline substantially over time.</p>

                <p>Yield farming also creates technological and economic risks. A strategy interacting with several <span class="term" data-term="blockchain/smart-contract">smart contracts</span> is exposed to the security of each component. Oracle failures, liquidity shortages, governance changes, and token-price declines can also affect results.</p>

                <p>When AMM liquidity is involved, users must consider <span class="term" data-term="defi/impermanent-loss">impermanent loss</span>. When borrowing or leveraged positions are involved, the strategy may also face <span class="term" data-term="defi/liquidation-threshold">liquidation</span>. The correct evaluation therefore requires more than comparing advertised yields.</p>

                <h3>Potential sources of yield</h3>

                <ul>
                    <li>trading fees from liquidity provision;</li>
                    <li>interest earned through lending;</li>
                    <li>protocol incentive tokens;</li>
                    <li>staking or liquidity incentives;</li>
                    <li>returns from automated compounding strategies.</li>
                </ul>'
            ],

            'liquidity-mining' => [
                'title' => 'What Is Liquidity Mining | TM Wiki',
                'description' => 'Liquidity mining rewards users for supplying assets to DeFi liquidity pools.',
                'name' => 'Liquidity Mining',
                'caption' => 'Rewards for supplying protocol liquidity',
                'definition' => '<p><strong>Liquidity mining</strong> is a mechanism that rewards users for supplying assets to <span class="term" data-term="defi/liquidity-pool">DeFi liquidity pools</span>. The additional rewards are commonly distributed in protocol tokens or other assets according to predefined rules.</p>

                <p>The main purpose of liquidity mining is to attract capital and increase available liquidity. Deeper liquidity can improve trading conditions, reduce price impact, and make a protocol more useful to other participants.</p>

                <p>A typical process begins when a user deposits assets into an eligible pool. The protocol tracks the user position and calculates rewards based on factors such as the amount supplied, duration, pool allocation, and current incentive schedule.</p>

                <p>Liquidity mining should be distinguished from ordinary trading-fee income. Trading fees arise from user activity, while liquidity-mining rewards are additional incentives funded according to the protocol design. A liquidity provider can receive both simultaneously.</p>

                <p>Liquidity-mining rewards are not risk-free. The reward token can lose value, emissions can dilute existing holders, and the underlying liquidity position can experience <span class="term" data-term="defi/impermanent-loss">impermanent loss</span>. Smart-contract and governance risks also remain.</p>

                <p>Liquidity mining is often used as one component of <span class="term" data-term="defi/yield-farming">yield farming</span>. Rewards can be reinvested into the same protocol or deployed into another protocol, creating increasingly complex strategies.</p>'
            ],

            'lending-protocol' => [
                'title' => 'What Is a Lending Protocol | TM Wiki',
                'description' => 'A lending protocol enables decentralized lending and borrowing of cryptoassets through smart contracts.',
                'name' => 'Lending Protocol',
                'caption' => 'Protocol for decentralized lending and borrowing',
                'definition' => '<p>A <strong>lending protocol</strong> is a DeFi protocol that allows users to supply cryptoassets to lending markets and borrow assets under rules enforced by <span class="term" data-term="blockchain/smart-contract">smart contracts</span>. The system manages deposits, debt, interest rates, collateral, and liquidation according to predefined parameters.</p>

                <p>A typical protocol maintains a shared reserve of an asset. A liquidity provider deposits that asset and earns interest. A borrower supplies <span class="term" data-term="defi/collateral">collateral</span> and can borrow assets from the available reserve.</p>

                <p>Most lending systems use overcollateralization. The borrower must provide collateral worth more than the borrowed amount because the protocol generally does not have a traditional credit-scoring or debt-collection mechanism.</p>

                <p>Interest rates often depend on utilization. When only a small portion of a reserve is borrowed, rates can be relatively low. As utilization increases, rates can rise to attract additional liquidity and discourage excessive borrowing.</p>

                <p>A lending protocol also requires liquidation rules. If collateral value falls and the position becomes insufficiently protected, third parties may be allowed to repay debt and receive collateral according to the protocol rules.</p>

                <p>Major risks include collateral volatility, smart-contract bugs, <span class="term" data-term="defi/price-oracle">price-oracle</span> failures, liquidity shortages, and extreme market conditions. TVL and interest rates alone are not sufficient measures of protocol safety.</p>'
            ],

            'borrowing' => [
                'title' => 'What Is Borrowing in DeFi | TM Wiki',
                'description' => 'Borrowing in DeFi is obtaining cryptoassets through a protocol using collateral and automated rules.',
                'name' => 'Borrowing',
                'caption' => 'Borrowing assets through DeFi protocols',
                'definition' => '<p><strong>Borrowing</strong> in DeFi is the process of obtaining cryptoassets from a lending protocol or shared liquidity market under rules enforced by smart contracts. In most systems, the borrower first deposits <span class="term" data-term="defi/collateral">collateral</span> and then receives the ability to borrow another asset.</p>

                <p>For example, a user can deposit a cryptoasset and borrow a stablecoin without selling the original asset. The collateral remains locked in the protocol while the loan is active and the borrower remains responsible for the debt and accrued interest.</p>

                <p>Borrowing capacity is determined by the value of the collateral and protocol risk parameters. A key metric is the <span class="term" data-term="defi/collateralization-ratio">collateralization ratio</span>. A higher required ratio means that the borrower can generally borrow a smaller amount relative to the collateral value.</p>

                <p>The value of both collateral and debt can change. A <span class="term" data-term="defi/price-oracle">price oracle</span> provides market prices used to evaluate the position. If collateral falls in value, the position can approach the <span class="term" data-term="defi/liquidation-threshold">liquidation threshold</span>.</p>

                <p>Borrowing can be used to obtain liquidity without selling an asset, construct trading positions, hedge exposure, or participate in other DeFi strategies. However, borrowing creates an obligation, so the expected return of the strategy must be evaluated together with interest and liquidation risk.</p>

                <p>Unlike a traditional bank loan, DeFi borrowing often does not depend on credit history or personal identification. Instead, the system relies primarily on collateral and automated rules. This increases accessibility while transferring substantial responsibility to the user.</p>'
            ],

            'collateral' => [
                'title' => 'What Is Collateral in DeFi | TM Wiki',
                'description' => 'Collateral is an asset deposited into a DeFi protocol to secure a loan or other financial position.',
                'name' => 'Collateral',
                'caption' => 'Asset securing a DeFi obligation',
                'definition' => '<p><strong>Collateral</strong> is an asset deposited by a user to secure a loan or another financial position in a DeFi protocol. It protects the lending system because the protocol can liquidate part of the collateral if the borrower no longer provides sufficient security for the outstanding debt.</p>

                <p>In decentralized lending, collateral is usually locked in a <span class="term" data-term="blockchain/smart-contract">smart contract</span>. The user does not transfer it to a bank employee or centralized lender. Instead, the contract controls the asset according to the rules encoded in the protocol.</p>

                <p>Most lending markets use overcollateralization. The value of the collateral must exceed the value of the debt, creating a buffer against market movements. The required buffer differs between assets and protocols.</p>

                <p>The value of collateral must be continuously or periodically evaluated. A <span class="term" data-term="defi/price-oracle">price oracle</span> commonly supplies the market price. If the collateral declines relative to the debt, the position becomes increasingly risky.</p>

                <p>When a position reaches the protocol <span class="term" data-term="defi/liquidation-threshold">liquidation threshold</span>, liquidators may be able to repay debt and receive a portion of the collateral according to the protocol rules.</p>

                <p>Collateral can also be used in complex composable strategies. An asset can serve as collateral in one protocol while borrowed assets are deployed elsewhere. This increases capital efficiency but also creates interconnected risks across several protocols.</p>'
            ],

            'collateralization-ratio' => [
                'title' => 'What Is the Collateralization Ratio | TM Wiki',
                'description' => 'The collateralization ratio measures the value of collateral relative to the outstanding debt in a DeFi position.',
                'name' => 'Collateralization Ratio',
                'caption' => 'Ratio of collateral value to debt value',
                'definition' => '<p>The <strong>collateralization ratio</strong> measures the relationship between the value of a user collateral position and the value of outstanding debt. It is a fundamental risk metric in DeFi lending systems.</p>

                <p>In simplified form, the ratio is calculated as collateral value divided by debt value. For example, if a user has 150 units of collateral and 100 units of debt, the collateralization ratio is 150%.</p>

                <p>A higher ratio provides a larger buffer against adverse price movements. If the collateral price declines while the debt remains similar, the ratio falls. Once the position reaches a protocol-defined risk level, liquidation may become possible.</p>

                <p>The collateralization ratio should be distinguished from the <span class="term" data-term="defi/liquidation-threshold">liquidation threshold</span>. The ratio describes the current state of a position, while the liquidation threshold is a protocol parameter defining when a position becomes eligible for liquidation. Some protocols also use loan-to-value as the inverse-style measure of debt relative to collateral.</p>

                <p>The calculation depends on market prices supplied through a <span class="term" data-term="defi/price-oracle">price oracle</span>. Oracle reliability is therefore directly connected to the accuracy of collateral-risk calculations.</p>

                <p>A borrower can generally improve the ratio by adding collateral or repaying debt. Both actions increase the safety margin of the position and reduce the probability of liquidation under moderate adverse price movements.</p>'
            ],

            'liquidation-threshold' => [
                'title' => 'What Is a Liquidation Threshold | TM Wiki',
                'description' => 'A liquidation threshold defines when a DeFi borrowing position can become subject to forced liquidation.',
                'name' => 'Liquidation Threshold',
                'caption' => 'Risk level at which a position can be liquidated',
                'definition' => '<p>A <strong>liquidation threshold</strong> is a parameter in a DeFi lending protocol that determines when a borrowing position becomes eligible for forced liquidation or partial liquidation. It is designed to protect lenders and maintain sufficient collateralization throughout the lending market.</p>

                <p>A borrower position depends on the value of its <span class="term" data-term="defi/collateral">collateral</span> and outstanding debt. When collateral falls in value, the safety margin decreases. Once the relevant threshold is reached, liquidators may be allowed to repay some or all of the debt in exchange for collateral.</p>

                <p>The threshold is determined by protocol risk parameters and can differ between assets. More volatile or less liquid collateral can require more conservative parameters because its market value can change rapidly.</p>

                <p>The protocol normally relies on a <span class="term" data-term="defi/price-oracle">price oracle</span> to determine the current value of collateral. An inaccurate or manipulated price can therefore cause incorrect risk assessments and potentially harmful liquidations.</p>

                <p>A liquidation threshold should not be treated as a guaranteed point at which the borrower will have enough time to manually close the position. During rapid market movements, network congestion, or liquidity shortages, the position can change quickly.</p>

                <p>Borrowers can reduce liquidation risk by maintaining a larger collateral buffer, repaying debt, or monitoring the position as market conditions change. The exact mechanics and penalties depend on the lending protocol.</p>'
            ],

            'decentralized-lending' => [
                'title' => 'What Is Decentralized Lending | TM Wiki',
                'description' => 'Decentralized lending enables crypto lending and borrowing through smart contracts without traditional credit intermediaries.',
                'name' => 'Decentralized Lending',
                'caption' => 'Blockchain-based lending without traditional intermediaries',
                'definition' => '<p><strong>Decentralized lending</strong> is a mechanism for supplying and borrowing cryptoassets through DeFi protocols and <span class="term" data-term="blockchain/smart-contract">smart contracts</span>. Instead of relying on a traditional bank or credit institution, the lending market uses programmed rules to manage deposits, debt, interest, collateral, and liquidation.</p>

                <p>Liquidity providers deposit assets into a lending market and can earn interest. Borrowers provide <span class="term" data-term="defi/collateral">collateral</span> and receive the ability to borrow available assets from the protocol.</p>

                <p>The market can automatically account for liquidity, utilization, interest rates, debt, and collateral values. If a position becomes undercollateralized, liquidation mechanisms can be activated according to predefined rules.</p>

                <p>Most decentralized lending systems rely on overcollateralization because the protocol generally cannot use traditional identity-based debt collection. Instead, the system must be able to enforce repayment economically through collateral.</p>

                <p>Decentralized lending can be used to obtain liquidity without selling long-term holdings, construct trading strategies, hedge positions, or participate in <span class="term" data-term="defi/yield-farming">yield-farming</span> strategies.</p>

                <p>Risks include smart-contract vulnerabilities, oracle failures, rapid market movements, liquidity shortages, and protocol governance risks. Unlike a traditional insured bank deposit, DeFi deposits generally do not have the same centralized protection mechanisms.</p>'
            ],

            'flash-loan' => [
                'title' => 'What Is a Flash Loan | TM Wiki',
                'description' => 'A flash loan is an uncollateralized DeFi loan that must be repaid within the same blockchain transaction.',
                'name' => 'Flash Loan',
                'caption' => 'Atomic loan without traditional collateral',
                'definition' => '<p>A <strong>flash loan</strong> is a DeFi mechanism that allows a user to temporarily borrow a large amount of assets without traditional collateral, provided that the entire loan is repaid within the same <span class="term" data-term="blockchain/transaction">blockchain transaction</span>. If the repayment condition is not satisfied, the transaction can revert and the intermediate state changes are not retained.</p>

                <p>The mechanism depends on the programmability and atomic execution of <span class="term" data-term="blockchain/smart-contract">smart contracts</span>. Within one transaction, a user can borrow assets, execute several operations across other protocols, and return the borrowed amount plus the required fee.</p>

                <p>One common use case is arbitrage. A user can temporarily borrow an asset, trade it where it is relatively cheap, sell it where it is relatively expensive, and repay the loan. If the complete sequence does not produce enough value to cover the loan and fees, the transaction should fail.</p>

                <p>Flash loans can also be used for refinancing, collateral restructuring, complex swaps, and other atomic operations. The borrower does not need to own capital equal to the loan amount because the funds are only temporarily available during transaction execution.</p>

                <p>Flash loans can become relevant to protocol security because they allow an attacker to temporarily control a large amount of capital. This can amplify economic exploits involving flawed pricing, governance assumptions, or accounting logic. The flash-loan mechanism itself is not necessarily a vulnerability; the underlying protocol logic must contain a weakness for the capital to be useful in an attack.</p>

                <p>Atomicity is the key property. If an essential step fails, the transaction can revert rather than leaving partially completed operations on-chain. The user can still lose the blockchain transaction fee associated with the failed attempt.</p>'
            ],

            'oracle' => [
                'title' => 'What Is an Oracle in Blockchain | TM Wiki',
                'description' => 'An oracle supplies external data to blockchain applications and smart contracts that cannot directly access the outside world.',
                'name' => 'Oracle',
                'caption' => 'External data infrastructure for smart contracts',
                'definition' => '<p>An <strong>oracle</strong> is a mechanism that supplies <span class="term" data-term="blockchain/smart-contract">smart contracts</span> with information that is not natively available in the <span class="term" data-term="blockchain/blockchain">blockchain</span> state. Oracles are especially important in DeFi because financial applications often require market prices and other external information.</p>

                <p>Blockchains are intentionally isolated from arbitrary external data. A smart contract cannot simply send an HTTP request to a website and treat the response as part of blockchain consensus. An oracle provides the infrastructure required to bring external information into the blockchain environment.</p>

                <p>An oracle can collect information from multiple sources and deliver an aggregated result on-chain. Different oracle systems use different approaches to data sourcing, aggregation, updates, and validation.</p>

                <p>In DeFi, oracles can provide the value of <span class="term" data-term="defi/collateral">collateral</span>, determine <span class="term" data-term="defi/liquidation-threshold">liquidation conditions</span>, support derivatives, and provide other market information required by financial contracts.</p>

                <p>Oracle security is therefore a major part of protocol security. If a protocol receives an incorrect price, an attacker may potentially borrow too much, trigger inappropriate liquidations, or manipulate the economic state of a system.</p>

                <p>Oracle designs range from centralized data providers to decentralized systems that aggregate multiple independent sources. The existence of an oracle does not by itself determine how decentralized or secure the complete protocol is.</p>'
            ],

            'price-oracle' => [
                'title' => 'What Is a Price Oracle | TM Wiki',
                'description' => 'A price oracle supplies DeFi protocols with market prices used for accounting, collateral valuation, and risk management.',
                'name' => 'Price Oracle',
                'caption' => 'Market-price source for DeFi protocols',
                'definition' => '<p>A <strong>price oracle</strong> is a specialized type of <span class="term" data-term="defi/oracle">oracle</span> that provides smart contracts with information about the market value of cryptoassets. Price data is required whenever a DeFi protocol needs to compare the value of different assets or enforce financial risk parameters.</p>

                <p>For example, a lending protocol needs to know the value of a user <span class="term" data-term="defi/collateral">collateral</span> position to determine borrowing capacity and whether the position has reached the <span class="term" data-term="defi/liquidation-threshold">liquidation threshold</span>.</p>

                <p>Price feeds can be constructed from multiple market sources. Using only one source can create a single point of failure or manipulation. Aggregating several sources can improve robustness, although it does not eliminate every possible oracle risk.</p>

                <p>Freshness is also important. During a rapidly moving market, an outdated price can differ substantially from the current market price. Protocols therefore define rules for updating prices and handling stale data.</p>

                <p>The quality and liquidity of the underlying markets also matter. A price derived from a thin or easily manipulated market can become unreliable even if the oracle software itself operates correctly.</p>

                <p>Price oracles are particularly important for lending, derivatives, stablecoins, and other financial applications. An oracle failure can directly affect <span class="term" data-term="defi/borrowing">borrowing</span>, liquidations, and the value assigned to assets within the protocol.</p>'
            ],

            'total-value-locked' => [
                'title' => 'What Is TVL | TM Wiki',
                'description' => 'TVL measures the total value of cryptoassets deposited or locked in a DeFi protocol, network, or ecosystem.',
                'name' => 'Total Value Locked',
                'caption' => 'Value of assets deposited in DeFi',
                'definition' => '<p><strong>Total Value Locked (TVL)</strong> is a metric representing the total market value of cryptoassets deposited into or controlled by a particular DeFi protocol, application, network, or ecosystem. The exact calculation depends on the analytics provider and its methodology.</p>

                <p>TVL can include assets held in <span class="term" data-term="defi/liquidity-pool">liquidity pools</span>, lending markets, collateral positions, staking contracts, and other smart-contract-controlled structures. Different platforms may include or exclude particular categories, so the definition should always be checked.</p>

                <p>Because TVL is normally expressed using market values, it can change without any actual deposits or withdrawals. If the market price of assets increases, the reported TVL can rise even if the number of deposited tokens remains unchanged.</p>

                <p>TVL is often used to compare the size of DeFi protocols and monitor capital flows. A high TVL indicates that a large amount of value is associated with a protocol, but it does not by itself prove that the protocol is secure, profitable, decentralized, or sustainable.</p>

                <p>TVL is more informative when considered alongside trading volume, protocol revenue, liquidity depth, user activity, asset concentration, and security history. The same capital can also appear in multiple connected protocols, so ecosystem-level aggregation requires careful methodology.</p>

                <p>Changes in TVL over time can provide useful information about capital inflows and outflows, but price movements must be separated from actual changes in deposited capital. A rising TVL can therefore have several different causes.</p>'
            ],

            'impermanent-loss' => [
                'title' => 'What Is Impermanent Loss | TM Wiki',
                'description' => 'Impermanent loss is the relative reduction in liquidity-provider value compared with simply holding the same assets outside a pool.',
                'name' => 'Impermanent Loss',
                'caption' => 'Relative loss caused by asset-price changes',
                'definition' => '<p><strong>Impermanent loss</strong> is the difference between the value of a liquidity-provider position and the value the same assets would have had if they had simply been held outside the <span class="term" data-term="defi/liquidity-pool">liquidity pool</span>. The effect is most common in pools where the quantities of assets automatically change as their relative market prices change.</p>

                <p>Consider a simple pool containing two assets. If the price of one asset changes significantly relative to the other, arbitrage traders trade against the pool until the pool price moves closer to the external market price. This process changes the quantities of both assets held on behalf of the liquidity provider.</p>

                <p>If the resulting position is compared with simply holding the original assets, the liquidity-provider position may be worth less. This relative difference is called impermanent loss.</p>

                <p>The term refers to the fact that the effect depends on the current relative prices. If prices return to their original relationship, the calculated impermanent loss can decrease or disappear. If the provider withdraws liquidity while the price relationship is unfavorable, the difference becomes effectively realized.</p>

                <p>Impermanent loss does not necessarily mean that the provider has lost money in absolute terms. The position can simultaneously earn trading fees and additional incentives. The final result depends on the balance between these revenues and the relative loss caused by price changes.</p>

                <h3>Factors affecting impermanent loss</h3>

                <ul>
                    <li>the change in relative asset prices;</li>
                    <li>the mathematical design of the liquidity pool;</li>
                    <li>the amount of time liquidity remains deployed;</li>
                    <li>trading fees earned by the provider;</li>
                    <li>additional protocol incentives;</li>
                    <li>changes in the absolute value of the underlying assets.</li>
                </ul>

                <p>Liquidity providers should therefore evaluate impermanent loss together with fees, transaction costs, asset volatility, and smart-contract risk rather than evaluating the advertised APY alone.</p>'
            ],

            'swap' => [
                'title' => 'What Is a Crypto Swap | TM Wiki',
                'description' => 'A crypto swap is an exchange of one cryptoasset for another through a DeFi protocol, AMM, or other exchange mechanism.',
                'name' => 'Swap',
                'caption' => 'Exchange of one cryptoasset for another',
                'definition' => '<p>A <strong>swap</strong> is an operation in which one cryptoasset is exchanged for another. In DeFi, swaps commonly take place through a <span class="term" data-term="defi/dapp">dApp</span> that interacts with a <span class="term" data-term="defi/liquidity-pool">liquidity pool</span> or another smart-contract-based exchange mechanism.</p>

                <p>Unlike a centralized exchange, where trades can be matched through an <span class="term" data-term="crypto-trading/order-book">order book</span> and <span class="term" data-term="crypto-exchanges/matching-engine">matching engine</span>, many DeFi swaps use an <span class="term" data-term="defi/automated-market-maker">AMM</span>. The execution price is then determined by pool reserves and the mathematical model used by the protocol.</p>

                <p>Before executing a swap, the user normally specifies the input asset, output asset, and amount. The interface displays an estimated result and can define a minimum acceptable output. This limit is related to the <span class="term" data-term="defi/slippage-tolerance">slippage tolerance</span>.</p>

                <p>The final result is affected by the pool price, trade size, available liquidity, protocol fees, and <span class="term" data-term="crypto-trading/slippage">slippage</span>. The user may also pay a <span class="term" data-term="blockchain/transaction-fee">blockchain transaction fee</span> for executing the transaction.</p>

                <p>A swap can use a direct market or multiple intermediate markets. For example, exchanging Token A for Token C may route through A/B and B/C pools. Multi-hop routing can improve execution but also introduces additional operations and costs.</p>

                <p>Users should verify the blockchain network, token contract addresses, expected output, and transaction permissions before signing. Signing a transaction authorizes the specified blockchain operation; it does not automatically make an unknown dApp trustworthy.</p>'
            ],

            'slippage-tolerance' => [
                'title' => 'What Is Slippage Tolerance | TM Wiki',
                'description' => 'Slippage tolerance defines the maximum acceptable execution-price deviation for a DeFi swap.',
                'name' => 'Slippage Tolerance',
                'caption' => 'Maximum acceptable price deviation',
                'definition' => '<p><strong>Slippage tolerance</strong> is a parameter that defines how far the final result of a swap may deviate from the expected result before the transaction is rejected. It is particularly important when trading through <span class="term" data-term="defi/automated-market-maker">AMMs</span> and <span class="term" data-term="defi/liquidity-pool">liquidity pools</span>.</p>

                <p>The displayed price before a transaction is submitted is not necessarily the final execution price. Between transaction construction and execution, other trades can change the pool reserves and therefore change the available exchange rate.</p>

                <p>Slippage tolerance establishes a boundary for acceptable execution. If the user expects a certain output amount, the smart contract can reject the operation when the actual output falls below the permitted minimum.</p>

                <p>A very low tolerance can cause legitimate transactions to fail when market conditions change slightly. A very high tolerance allows execution under a much wider range of prices and can expose the user to unfavorable execution.</p>

                <p>Slippage tolerance should be distinguished from actual <span class="term" data-term="crypto-trading/slippage">slippage</span>. Tolerance is the limit selected by the user, while slippage is the actual difference between expected and executed pricing.</p>

                <p>The appropriate setting depends on market liquidity, trade size, volatility, and the design of the protocol. Users should be especially careful with unusually high tolerance values on unfamiliar interfaces because they permit execution across a wider price range.</p>'
            ],

            'dao' => [
                'title' => 'What Is a DAO | TM Wiki',
                'description' => 'A DAO is a decentralized organization that uses blockchain, tokens, and smart contracts for governance and collective decision-making.',
                'name' => 'DAO',
                'caption' => 'Decentralized governance model',
                'definition' => '<p>A <strong>DAO</strong>, or Decentralized Autonomous Organization, is an organizational model in which governance and decision-making are implemented using <span class="term" data-term="blockchain/blockchain">blockchain</span>, <span class="term" data-term="blockchain/smart-contract">smart contracts</span>, and voting mechanisms. DAOs are commonly used to govern DeFi protocols, treasury assets, protocol parameters, and ecosystem development.</p>

                <p>DAO participants can submit proposals, discuss them, and vote on their adoption. Depending on the system, voting power may be based on governance tokens, delegated voting rights, reputation, or another mechanism. Therefore, holding a governance token does not necessarily mean that every participant has equal influence.</p>

                <p>Governance proposals can change protocol fees, risk parameters, supported assets, treasury allocations, contract upgrades, or other rules. In some systems, a successful vote is executed automatically by a smart contract. In others, an additional execution process or administrator is required.</p>

                <p>Many DAOs control a treasury containing <span class="term" data-term="cryptocurrency/crypto-asset">cryptoassets</span>. Treasury operations may be protected through <span class="term" data-term="crypto-wallets/multisig">multisig</span> wallets, timelocks, or other mechanisms. The actual level of automation therefore depends on the DAO architecture.</p>

                <p>A DAO does not automatically guarantee complete decentralization. Governance tokens can be concentrated among a small number of holders, important technical components can remain under limited control, and low voter participation can result in significant differences between nominal and practical governance power.</p>

                <p>In DeFi, a DAO can serve as a governance layer around an otherwise automated financial protocol. The protocol can execute financial operations through smart contracts while the DAO determines longer-term parameters and development decisions.</p>

                <h3>Core DAO components</h3>

                <ul>
                    <li><strong>Proposal</strong> — a proposed action or change.</li>
                    <li><strong>Governance</strong> — the rules and mechanisms for collective decision-making.</li>
                    <li><strong>Voting</strong> — the process used to approve or reject proposals.</li>
                    <li><strong>Treasury</strong> — assets controlled by the organization.</li>
                    <li><strong>Execution</strong> — the mechanism that applies an approved decision.</li>
                </ul>'
            ],
        ],
    ],

    'staking' => [
        'title' => 'Staking and PoS Terms',
        'description' => 'Staking and Proof-of-Stake glossary covering validators, delegation, staking, slashing, APR, APY and other terms.',
        'name' => 'Staking',
        'caption' => 'Terms related to staking and Proof-of-Stake, including validators, delegation, rewards, slashing, APR, APY and other concepts.',
        'terms' => [
            'staking' => [
                'title' => 'What Is Staking | TM Wiki',
                'description' => 'Staking is a way to participate in Proof-of-Stake and earn rewards by locking or delegating crypto assets.',
                'name' => 'Staking',
                'caption' => 'Participating in Proof-of-Stake with crypto assets',
                'definition' => '<p><strong>Staking</strong> is a mechanism for participating in a blockchain that uses <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> or a related consensus model such as <span class="term" data-term="staking/delegated-proof-of-stake">Delegated Proof-of-Stake</span>. A user locks or delegates a certain amount of a network-native asset and may receive <span class="term" data-term="staking/staking-reward">staking rewards</span> in return. Depending on the network, staking can help select participants that validate blocks, provide economic security, and distribute newly issued coins or transaction fees.</p>

                <p>Staking differs fundamentally from <span class="term" data-term="mining/mining">mining</span> in <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span> networks. Proof-of-Work relies on computational resources and electricity, while Proof-of-Stake uses capital placed at economic risk. As a result, staking generally does not require an <span class="term" data-term="mining-equipment/asic-miner">ASIC miner</span> or a <span class="term" data-term="mining-equipment/gpu-rig">GPU rig</span>. A user can delegate assets to an existing <span class="term" data-term="staking/validator">validator</span> or operate a <span class="term" data-term="staking/validator-node">validator node</span>.</p>

                <p>Staking rewards should not automatically be treated as profit. Rewards are generally paid in the network\'s native asset, so their value in fiat currency depends on the market price of the <span class="term" data-term="cryptocurrency/coin">coin</span>. Validator commissions, token inflation, lock-up rules, unbonding periods, penalties, and other protocol parameters can also affect the final economic result.</p>

                <h3>How staking works</h3>

                <p>In a simple model, a user chooses a network and a participation method, acquires or already holds its native asset, and commits that asset to the staking mechanism. The assets may be directly associated with a validator or locked through a dedicated smart contract. The protocol then considers the participant\'s economic stake when selecting validators and distributing rewards.</p>

                <ul>
                    <li>the user locks or delegates an asset;</li>
                    <li>the asset becomes part of the network\'s economic security;</li>
                    <li>validators participate in block production and validation;</li>
                    <li>the protocol distributes rewards according to its rules;</li>
                    <li>a <span class="term" data-term="staking/validator-commission">validator commission</span> may be deducted from rewards;</li>
                    <li>protocol violations may result in penalties, including <span class="term" data-term="staking/slashing">slashing</span>.</li>
                </ul>

                <p>The exact mechanics differ substantially between blockchains. Therefore, the word staking does not describe one identical operation across all networks. One network may allow a user to retain direct control over assets while delegating them, another may require interaction with a smart contract, and another may use its own locking and reward-distribution rules.</p>

                <h3>What determines staking yield</h3>

                <p>Staking returns are commonly described using <span class="term" data-term="staking/staking-apr">APR</span> or <span class="term" data-term="staking/staking-apy">APY</span>. These figures can appear attractive but do not guarantee a positive return in fiat terms. A user may receive more coins while the market price of those coins falls enough to reduce the value of the position.</p>

                <p>Network issuance also matters. If a protocol creates new coins to fund staking rewards, part of the nominal return may be offset by dilution of the holder\'s share of the total supply. A meaningful staking analysis therefore considers nominal rewards, inflation, commissions, price changes, and withdrawal conditions separately.</p>

                <h3>Main participation models</h3>

                <ul>
                    <li><strong>Running a validator</strong> — the user operates a <span class="term" data-term="staking/validator-node">validator node</span> and is responsible for its infrastructure.</li>
                    <li><strong>Delegation</strong> — the user assigns staking weight to a selected validator without operating the infrastructure.</li>
                    <li><strong>Liquid staking</strong> — the user stakes an asset through a protocol and receives a <span class="term" data-term="staking/liquid-staking-token">liquid staking token</span>.</li>
                    <li><strong>Restaking</strong> — an already-staked asset or its derivative is used to provide security to additional services or protocols.</li>
                </ul>

                <p>Staking therefore combines a blockchain\'s technical consensus mechanism with its economic model. Evaluating a particular staking opportunity requires more than looking at the advertised yield: capital requirements, validator risk, lock-up rules, withdrawal conditions, commissions, penalty rules, and the underlying asset all matter.</p>'
            ],

            'proof-of-stake' => [
                'title' => 'What Is Proof-of-Stake | TM Wiki',
                'description' => 'Proof-of-Stake is a consensus mechanism that uses economically committed assets to secure a blockchain.',
                'name' => 'Proof-of-Stake',
                'caption' => 'Consensus secured through economically committed stake',
                'definition' => '<p><strong>Proof-of-Stake (PoS)</strong> is a <span class="term" data-term="blockchain/consensus">consensus mechanism</span> in which blockchain security is provided by economically committed participants who place crypto assets into staking. These participants are commonly called <span class="term" data-term="staking/validator">validators</span>. The protocol selects validators to perform functions related to proposing, validating, and finalizing <span class="term" data-term="blockchain/block">blocks</span>, while violations of protocol rules may result in the loss of some of the committed stake.</p>

                <p>The central idea of PoS is that a participant\'s ability to take part in consensus is connected to economic commitment rather than the expenditure of massive computational resources. A participant puts capital at risk: correct behavior can generate rewards, while certain forms of malicious or incorrect behavior can result in <span class="term" data-term="staking/slashing">slashing</span>.</p>

                <h3>Why Proof-of-Stake is needed</h3>

                <p>A blockchain needs a mechanism that allows distributed nodes to agree on the state of a shared <span class="term" data-term="blockchain/blockchain">blockchain</span>. Nodes must determine which transactions belong in blocks and which version of the chain should be accepted. PoS addresses this through rules for selecting and evaluating validators together with economic incentives and penalties.</p>

                <p>An important property of PoS is that protocol security is connected to the value of assets placed at risk. Depending on the protocol, an attacker may need to control a substantial amount of stake to influence consensus. The exact security model, voting thresholds, and consequences of attacks vary significantly between PoS implementations.</p>

                <h3>A typical PoS cycle</h3>

                <ol>
                    <li>participants lock or delegate assets;</li>
                    <li>the protocol forms an active validator set;</li>
                    <li>one or more validators receive duties related to block production or validation;</li>
                    <li>other participants verify the proposed data;</li>
                    <li>the block is accepted when the protocol\'s consensus conditions are satisfied;</li>
                    <li>validators receive rewards or penalties depending on their behavior.</li>
                </ol>

                <p>Different PoS networks use different validator-selection, finality, and penalty rules. PoS is therefore best understood as a family of consensus designs rather than one identical algorithm used by every blockchain.</p>

                <h3>PoS versus Proof-of-Work</h3>

                <p>In Proof-of-Work, participants compete through computational resources and energy expenditure. In Proof-of-Stake, capital becomes the primary economic resource. This changes the cost and risk structure: PoS networks care about stake requirements, validator reliability, networking, software, penalty rules, and reward distribution, while PoW mining depends heavily on <span class="term" data-term="equipment-specifications/hashrate">hashrate</span>, <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span>, and electricity costs.</p>

                <p>PoS does not mean that infrastructure is unnecessary. Professional validators may use servers, backup power, monitoring systems, network infrastructure, and remote-management tools. The reliability of this infrastructure directly affects a validator\'s ability to perform its duties consistently.</p>'
            ],

            'validator' => [
                'title' => 'What Is a Validator | TM Wiki',
                'description' => 'A validator is a Proof-of-Stake participant that helps verify transactions and maintain blockchain consensus.',
                'name' => 'Validator',
                'caption' => 'A network participant responsible for consensus operations',
                'definition' => '<p>A <strong>validator</strong> is a participant in a <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> blockchain that performs protocol-defined functions for verifying and maintaining network state. Depending on the blockchain, a validator may propose new <span class="term" data-term="blockchain/block">blocks</span>, vote on blocks proposed by other participants, participate in finalization, or perform other consensus operations.</p>

                <p>A validator usually needs a certain amount of its own or delegated stake to participate. This capital acts as economic security for the validator\'s behavior. Correct and available validators may receive <span class="term" data-term="staking/staking-reward">staking rewards</span>, while certain protocol violations or failures may lead to penalties or <span class="term" data-term="staking/slashing">slashing</span>.</p>

                <h3>What a validator does</h3>

                <ul>
                    <li>maintains a functioning blockchain node;</li>
                    <li>receives and validates network data;</li>
                    <li>participates in block production or confirmation;</li>
                    <li>signs protocol messages when required;</li>
                    <li>maintains reliable network connectivity;</li>
                    <li>monitors software and infrastructure;</li>
                    <li>protects the keys required for validator operations.</li>
                </ul>

                <p>Running a validator requires more technical responsibility than simply delegating coins. The operator must maintain a <span class="term" data-term="staking/validator-node">validator node</span>, update software, secure keys, monitor server availability, and respond to network events.</p>

                <h3>Validator and delegator</h3>

                <p>A <span class="term" data-term="staking/delegator">delegator</span> can assign economic weight to a selected validator without operating the infrastructure itself. The validator performs the technical work, while the delegator receives a share of available rewards after the validator\'s commission and protocol rules are applied.</p>

                <p>Choosing a validator therefore involves more than looking at the advertised reward rate. Reliability, commission, operational history, stake concentration, protocol rules, and penalty exposure can all matter. Past performance does not guarantee future results.</p>'
            ],

            'delegator' => [
                'title' => 'What Is a Delegator | TM Wiki',
                'description' => 'A delegator participates in Proof-of-Stake by assigning staking weight to a selected validator.',
                'name' => 'Delegator',
                'caption' => 'A stake owner participating through delegation',
                'definition' => '<p>A <strong>delegator</strong> is a user or organization that participates in <span class="term" data-term="staking/staking">staking</span> by assigning economic weight to a selected <span class="term" data-term="staking/validator">validator</span>. A delegator does not necessarily need to operate a <span class="term" data-term="staking/validator-node">validator node</span>: the validator performs the technical duties while the delegated assets are included in the network\'s consensus rules.</p>

                <p>Delegation does not necessarily mean transferring ownership of the coins to the validator. In many PoS networks, the delegator retains control of the relevant account and can perform protocol-supported operations. However, the assets may become subject to staking conditions, including an <span class="term" data-term="staking/unbonding-period">unbonding period</span> and restrictions on immediate transfers.</p>

                <h3>How delegation works</h3>

                <ol>
                    <li>the delegator selects a validator;</li>
                    <li>the delegator chooses the amount to delegate;</li>
                    <li>the user signs the relevant transaction;</li>
                    <li>the protocol includes the delegated stake in its consensus rules;</li>
                    <li>rewards are distributed when protocol conditions are met;</li>
                    <li>a <span class="term" data-term="staking/validator-commission">validator commission</span> may be deducted from rewards.</li>
                </ol>

                <p>The delegator also takes some of the risks associated with the selected validator. In networks where penalties apply to delegated stake, validator behavior can have financial consequences for delegators.</p>'
            ],

            'delegation' => [
                'title' => 'What Is Staking Delegation | TM Wiki',
                'description' => 'Delegation assigns staking weight to a validator so users can participate in Proof-of-Stake without running their own validator.',
                'name' => 'Delegation',
                'caption' => 'Participating in PoS through a selected validator',
                'definition' => '<p><strong>Delegation</strong> is a mechanism in which a crypto asset holder assigns staking weight to a specific <span class="term" data-term="staking/validator">validator</span>. The delegated capital increases the validator\'s economic weight according to the rules of the relevant <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> protocol. The user does not necessarily need to operate the technical infrastructure.</p>

                <p>Delegation separates two roles. The validator operates infrastructure and performs consensus duties, while the <span class="term" data-term="staking/delegator">delegator</span> supplies economic weight. In some networks, delegators can vote, choose validators, or move their stake between validators.</p>

                <p>A key parameter is the time required to exit staking. After undelegation, assets may not become immediately available because the protocol can impose an <span class="term" data-term="staking/unbonding-period">unbonding period</span>. Its duration depends on the network.</p>

                <p>Delegation is also associated with validator risk. If a protocol applies economic penalties for certain violations, delegated stake may be affected by those penalties. Validator commission is therefore only one of the factors that matters when evaluating a validator.</p>'
            ],

            'validator-node' => [
                'title' => 'What Is a Validator Node | TM Wiki',
                'description' => 'A validator node is server infrastructure used to participate in Proof-of-Stake consensus.',
                'name' => 'Validator Node',
                'caption' => 'Infrastructure used to operate a blockchain validator',
                'definition' => '<p>A <strong>validator node</strong> is the software and hardware infrastructure used by a validator to participate in blockchain consensus. It normally includes a server, blockchain software, network connectivity, and cryptographic keys required to sign protocol messages.</p>

                <p>The node must maintain an up-to-date state of the <span class="term" data-term="blockchain/blockchain">blockchain</span>, process incoming data, and perform the operations required by the protocol. Depending on the network, a validator may propose blocks, vote on other proposals, or participate in finalization.</p>

                <h3>Infrastructure requirements</h3>

                <ul>
                    <li>sufficient CPU and memory resources;</li>
                    <li>stable and adequate network connectivity;</li>
                    <li>sufficient storage capacity;</li>
                    <li>reliable power and appropriate redundancy;</li>
                    <li>availability and performance monitoring;</li>
                    <li>secure key storage;</li>
                    <li>regular software updates.</li>
                </ul>

                <p>Node availability is particularly important because some protocols reduce rewards or impose penalties when validators fail to perform required duties. More serious violations can result in <span class="term" data-term="staking/slashing">slashing</span>.</p>

                <p>Unlike an ordinary <span class="term" data-term="blockchain/full-node">full node</span>, a validator node does more than maintain and verify network state: it performs additional consensus-related functions. The exact requirements depend on the blockchain.</p>'
            ],

            'staking-reward' => [
                'title' => 'What Is a Staking Reward | TM Wiki',
                'description' => 'A staking reward is a payment to Proof-of-Stake participants for performing protocol-defined duties.',
                'name' => 'Staking Reward',
                'caption' => 'Rewards earned for participating in Proof-of-Stake',
                'definition' => '<p>A <strong>staking reward</strong> is a crypto asset distributed to validators and, depending on the network, their delegators for participating in the operation and security of a <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> network. Rewards may come from newly issued coins, a portion of <span class="term" data-term="blockchain/transaction-fee">transaction fees</span>, or a combination of sources.</p>

                <p>The amount of reward depends on the protocol. Factors can include the total amount staked, a validator\'s share of stake, validator availability, correctly performed duties, validator commission, and the network\'s issuance model.</p>

                <p>A staking reward is not automatically equivalent to net profit. Inflation, market-price changes, commissions, and other costs can make the financial result very different from the nominal number of tokens received.</p>

                <h3>Example</h3>

                <p>If a user stakes 100 coins and receives 5 additional coins over a period, the nominal increase is 5%. If the market price of the coin falls by 20% during the same period, however, the fiat value of the position can still decline. Staking should therefore be evaluated both in units of the asset and in the user\'s chosen reporting currency.</p>'
            ],

            'staking-yield' => [
                'title' => 'What Is Staking Yield | TM Wiki',
                'description' => 'Staking yield measures the rewards earned from a staked asset over a specified period.',
                'name' => 'Staking Yield',
                'caption' => 'Return generated by staking a crypto asset',
                'definition' => '<p><strong>Staking yield</strong> describes how much reward a user receives relative to the amount of capital committed to staking over a given period. It may be expressed as a percentage or as the number of additional tokens earned.</p>

                <p>Yield should be distinguished from <span class="term" data-term="staking/staking-apr">APR</span> and <span class="term" data-term="staking/staking-apy">APY</span>. APR generally represents a simple annualized rate without compounding, while APY may incorporate the effect of reinvesting rewards. A displayed protocol yield may also be quoted before validator commissions, inflation effects, or changes in the market price of the asset.</p>

                <p>Meaningful yield comparisons should consider lock-up rules, <span class="term" data-term="staking/unbonding-period">unbonding periods</span>, penalty exposure, validator commission, token issuance, and market liquidity. A high nominal percentage does not by itself describe the complete risk or economic outcome.</p>'
            ],

            'staking-apr' => [
                'title' => 'What Is Staking APR | TM Wiki',
                'description' => 'Staking APR is an annualized simple staking return that does not account for compounding rewards.',
                'name' => 'Staking APR',
                'caption' => 'Annual staking rate without compounding',
                'definition' => '<p><strong>Staking APR</strong> is an annualized percentage rate used to describe staking rewards without assuming that those rewards are reinvested. APR stands for Annual Percentage Rate.</p>

                <p>If the APR is 10%, a simplified interpretation is that under unchanged conditions a user could receive rewards equivalent to approximately 10% of the initial stake over one year. In an actual protocol, the rate can change because of issuance, total network stake, participation levels, and other parameters.</p>

                <p>APR is useful for describing a base annualized rate without compounding. <span class="term" data-term="staking/staking-apy">APY</span> can be used when the calculation assumes repeated reinvestment. Neither metric necessarily captures changes in the token\'s market price, commissions, penalties, or withdrawal restrictions.</p>'
            ],

            'staking-apy' => [
                'title' => 'What Is Staking APY | TM Wiki',
                'description' => 'Staking APY is an effective annual yield that accounts for the assumed reinvestment of staking rewards.',
                'name' => 'Staking APY',
                'caption' => 'Annual staking yield with assumed compounding',
                'definition' => '<p><strong>Staking APY</strong> is an effective annual yield that incorporates the assumed reinvestment of earned staking rewards. APY stands for Annual Percentage Yield.</p>

                <p>If rewards are regularly added to the staked balance and then generate additional rewards themselves, the final number of tokens can be higher than under simple non-compounded accrual represented by <span class="term" data-term="staking/staking-apr">APR</span>. With frequent compounding, APY can therefore exceed the corresponding simple APR.</p>

                <p>In practice, a published APY is a model rather than a guarantee. The user must actually reinvest rewards at the assumed frequency, and protocol conditions must remain sufficiently stable. Fees, changing reward rates, reinvestment limitations, and market-price changes can materially affect the realized result.</p>'
            ],

            'unbonding-period' => [
                'title' => 'What Is an Unbonding Period | TM Wiki',
                'description' => 'An unbonding period is the time required for staked assets to become available after staking is canceled.',
                'name' => 'Unbonding Period',
                'caption' => 'The withdrawal period after leaving staking',
                'definition' => '<p>An <strong>unbonding period</strong> is the period between a request to exit staking or cancel delegation and the point at which the assets become freely available again. The term is especially common in networks that use delegation.</p>

                <p>During this period, the asset typically stops participating in future staking cycles but is not yet available for normal transfers or spending. The duration is determined by the blockchain protocol and can range from hours to weeks or longer.</p>

                <p>An unbonding period is an important liquidity constraint. A user cannot always immediately sell or transfer an asset after requesting an exit from staking.</p>

                <p>Liquid staking, represented by <span class="term" data-term="staking/liquid-staking">liquid staking</span>, can reduce the practical impact of this waiting period by giving the user a <span class="term" data-term="staking/liquid-staking-token">liquid staking token</span> that may be used elsewhere. This does not eliminate the underlying risks; it changes the liquidity model.</p>'
            ],

            'bonding-period' => [
                'title' => 'What Is a Bonding Period | TM Wiki',
                'description' => 'A bonding period is the time required for an asset to enter an active staking state under a protocol.',
                'name' => 'Bonding Period',
                'caption' => 'The period required to enter staking',
                'definition' => '<p>A <strong>bonding period</strong> is a period specified by some blockchain protocols during which an asset transitions into a state where it participates in staking. The exact mechanism varies: in some networks delegation becomes active immediately, while others require waiting for a new epoch, round, or a defined number of blocks.</p>

                <p>A bonding period differs from an <span class="term" data-term="staking/unbonding-period">unbonding period</span>. Bonding concerns entry into staking, while unbonding concerns exit. Both affect capital availability and therefore matter when planning liquidity.</p>

                <p>If a user commits an asset to staking in order to earn <span class="term" data-term="staking/staking-reward">rewards</span>, it is important to determine when the protocol begins counting the stake and whether a delay exists between delegation and effective participation.</p>'
            ],

            'lock-up-period' => [
                'title' => 'What Is a Lock-Up Period | TM Wiki',
                'description' => 'A lock-up period is a period during which staked assets cannot be freely withdrawn or transferred.',
                'name' => 'Lock-Up Period',
                'caption' => 'A mandatory period during which assets remain locked',
                'definition' => '<p>A <strong>lock-up period</strong> is a period defined by protocol rules during which an asset remains locked and cannot be freely used by its owner. In staking, a lock-up can apply to the initial commitment of funds, the staking position itself, or a period following an exit request.</p>

                <p>A lock-up period is not a universal property of every PoS network. Some protocols allow relatively quick withdrawals, others use a fixed lock-up, and others rely primarily on a separate <span class="term" data-term="staking/unbonding-period">unbonding period</span>.</p>

                <p>The longer capital remains locked, the lower its immediate liquidity. This matters when the asset might otherwise be needed for a <span class="term" data-term="defi/swap">swap</span>, <span class="term" data-term="defi/lending-protocol">lending</span>, trading, or another operation.</p>'
            ],

            'slashing' => [
                'title' => 'What Is Slashing | TM Wiki',
                'description' => 'Slashing is a Proof-of-Stake penalty that can reduce a validator\'s stake for certain protocol violations.',
                'name' => 'Slashing',
                'caption' => 'An economic penalty for violating PoS rules',
                'definition' => '<p><strong>Slashing</strong> is an economic penalty used by some <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> networks to reduce a validator\'s committed stake when the validator violates specific protocol rules. The purpose is to make certain forms of malicious or critically incorrect behavior economically costly.</p>

                <p>Slashing should be distinguished from simply losing potential rewards because of poor availability. Missing some duties may reduce expected rewards, while slashing normally involves an actual reduction of economic stake. The exact conditions vary between blockchains.</p>

                <h3>What can cause slashing</h3>

                <p>A well-known class of violations involves signing incompatible messages, such as voting for conflicting states when the protocol prohibits that behavior. Such actions can threaten consensus safety. Other networks define additional conditions that can result in penalties.</p>

                <p>The size of a slash is determined by the network. It can depend on the type of violation, the amount staked, the number of related violations, and protocol-wide conditions. There is therefore no universal slashing percentage that applies to all PoS networks.</p>

                <h3>Risk for delegators</h3>

                <p>In some models, penalties affect not only the validator\'s own funds but also stake delegated to that validator. As a result, a <span class="term" data-term="staking/delegator">delegator</span> can take on part of the validator\'s operational and protocol risk without operating the validator itself.</p>

                <p>Validators reduce operational risk through secure infrastructure, key management, redundancy, and monitoring. Preventing situations in which multiple validator instances sign conflicting messages is particularly important.</p>'
            ],

            'validator-commission' => [
                'title' => 'What Is Validator Commission | TM Wiki',
                'description' => 'Validator commission is the share of staking rewards retained by a validator for operating its infrastructure.',
                'name' => 'Validator Commission',
                'caption' => 'A fee taken from staking rewards by the validator',
                'definition' => '<p><strong>Validator commission</strong> is the percentage or other share of staking rewards that a validator retains for providing infrastructure and performing network duties. It is commonly applied to rewards associated with delegated stake.</p>

                <p>For example, if a validator sets a 5% commission, this does not normally mean that 5% of the delegated principal is transferred to the validator. It generally means that the validator retains a portion of the relevant rewards. The exact calculation depends on the protocol.</p>

                <p>Commission is only one parameter when comparing validators. Reliability, uptime, operational history, stake concentration, commission-change rules, and exposure to <span class="term" data-term="staking/slashing">slashing</span> can also matter.</p>

                <p>Some protocols impose minimum or maximum commission rates and rules governing changes. Users should therefore consider not only the current rate but also the conditions under which the validator can change it.</p>'
            ],

            'minimum-stake' => [
                'title' => 'What Is Minimum Stake | TM Wiki',
                'description' => 'Minimum stake is the minimum amount of a crypto asset required for a particular type of staking participation.',
                'name' => 'Minimum Stake',
                'caption' => 'The minimum amount required for staking participation',
                'definition' => '<p><strong>Minimum stake</strong> is the minimum amount of a crypto asset required by a protocol for a particular form of <span class="term" data-term="staking/staking">staking</span> participation. The requirement may apply to running a validator, delegating stake, or another role defined by the network.</p>

                <p>Minimum stake requirements are not identical across networks or roles. A protocol may require a substantial amount for operating a validator while allowing delegators to participate with a much smaller balance.</p>

                <p>The threshold is often denominated in the network\'s native asset, so its equivalent fiat value changes with the market price. Protocol governance or network upgrades can also change the minimum stake over time.</p>'
            ],

            'liquid-staking' => [
                'title' => 'What Is Liquid Staking | TM Wiki',
                'description' => 'Liquid staking lets users receive a liquid token representing a staked position that can be used in other crypto protocols.',
                'name' => 'Liquid Staking',
                'caption' => 'Staking with a transferable derivative position',
                'definition' => '<p><strong>Liquid staking</strong> is a staking model in which a user commits an asset to a staking protocol and receives a derivative asset called a <span class="term" data-term="staking/liquid-staking-token">liquid staking token</span>. The derivative represents an economic claim or position connected to the underlying staked asset and its accumulated results according to the protocol\'s rules.</p>

                <p>Traditional staking can restrict capital because of an <span class="term" data-term="staking/unbonding-period">unbonding period</span>. Liquid staking allows the user to hold a derivative token instead and potentially use it in other applications, such as <span class="term" data-term="defi/lending-protocol">DeFi lending</span>, a <span class="term" data-term="defi/liquidity-pool">liquidity pool</span>, or a <span class="term" data-term="defi/swap">swap</span>.</p>

                <h3>How liquid staking works</h3>

                <ol>
                    <li>the user supplies a native asset to the protocol;</li>
                    <li>the protocol stakes the asset or delegates it to validators;</li>
                    <li>the user receives a derivative liquid staking token;</li>
                    <li>the derivative can circulate independently from the underlying asset;</li>
                    <li>its quantity or exchange value can reflect accumulated staking rewards;</li>
                    <li>the protocol provides a mechanism for redeeming or otherwise recovering the underlying asset.</li>
                </ol>

                <p>Liquid staking does not eliminate staking risk. It adds another layer of protocol risk: besides the blockchain and validator risks, the user may face smart-contract risk, token-accounting risk, liquidity risk, and the possibility that the derivative trades away from its expected value relative to the underlying asset.</p>

                <p>If the liquid staking token is used in another <span class="term" data-term="defi/defi">DeFi</span> protocol, these risks can compound. A position may simultaneously depend on staking, smart contracts, market liquidity, and the rules of an external application.</p>'
            ],

            'liquid-staking-token' => [
                'title' => 'What Is a Liquid Staking Token | TM Wiki',
                'description' => 'A liquid staking token is a derivative asset representing a user\'s position in a liquid staking protocol.',
                'name' => 'Liquid Staking Token',
                'caption' => 'A liquid derivative linked to a staked asset',
                'definition' => '<p>A <strong>liquid staking token (LST)</strong> is a derivative crypto asset received when participating in <span class="term" data-term="staking/liquid-staking">liquid staking</span>. It represents a claim or economic position connected to the underlying staked asset and can be used separately from that asset.</p>

                <p>Depending on the protocol, the quantity or value of an LST can reflect accumulated staking rewards. For example, the exchange rate between an LST and the underlying asset may gradually change as staking rewards accrue.</p>

                <p>The main difference between an LST and a conventional staked balance is that the derivative can potentially be used in other applications. It may be supplied to a <span class="term" data-term="defi/liquidity-pool">liquidity pool</span>, deposited into a <span class="term" data-term="defi/lending-protocol">lending protocol</span>, or exchanged if the relevant application supports the asset.</p>

                <p>However, an LST introduces risks that direct ownership of the underlying asset may not have. These can include smart-contract risk, validator risk, staking-mechanism risk, liquidity risk, and the possibility that the market price of the derivative deviates from the expected value of the underlying asset.</p>'
            ],

            'restaking' => [
                'title' => 'What Is Restaking | TM Wiki',
                'description' => 'Restaking reuses an already-staked asset to provide additional economic security to other services or protocols.',
                'name' => 'Restaking',
                'caption' => 'Reusing stake to secure additional protocols',
                'definition' => '<p><strong>Restaking</strong> is a mechanism in which an asset already used to secure a <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> network is additionally used to secure other services, protocols, or infrastructure. The idea is to reuse existing economic collateral rather than requiring each additional system to build a completely independent stake base.</p>

                <p>In a conventional PoS model, staked assets secure the primary blockchain. Under restaking, the same economic capital can take on additional obligations. Depending on the implementation, users may accept additional conditions and additional exposure to penalties.</p>

                <h3>Why restaking is used</h3>

                <p>A new protocol or service may require economic security without having a large native asset base of its own. Reusing existing PoS stake can allow it to obtain economic security from participants in an established staking ecosystem.</p>

                <p>For users, the potential attraction is the ability to receive additional rewards on top of base staking returns. However, additional rewards correspond to additional obligations and risks; they should not be treated as risk-free incremental yield.</p>

                <h3>Additional risk</h3>

                <p>With restaking, the same capital can become subject to several systems simultaneously. Depending on the architecture, a failure to satisfy the rules of an additional service can have consequences for the user\'s position. The base staking conditions and every additional service therefore need to be evaluated separately.</p>

                <p>Restaking can also use <span class="term" data-term="staking/liquid-staking-token">liquid staking tokens</span> to represent the underlying staking position. In that case, the risks of the PoS network are combined with the risks of the derivative token and the restaking infrastructure.</p>'
            ],

            'delegated-proof-of-stake' => [
                'title' => 'What Is Delegated Proof-of-Stake | TM Wiki',
                'description' => 'Delegated Proof-of-Stake is a consensus model where token holders delegate voting power to selected block producers.',
                'name' => 'Delegated Proof-of-Stake',
                'caption' => 'A PoS model based on delegated voting power',
                'definition' => '<p><strong>Delegated Proof-of-Stake (DPoS)</strong> is a form of <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> in which token holders use their economic or voting power to select a limited set of participants responsible for producing or confirming blocks. These participants may be called delegates, block producers, or other protocol-specific names.</p>

                <p>In a conventional PoS model, users may directly delegate assets to validators, while DPoS often places greater emphasis on voting for a limited set of block producers. The exact implementation differs significantly between blockchains, so DPoS should not be reduced to one universal formula.</p>

                <h3>Basic DPoS model</h3>

                <ol>
                    <li>token holders receive a defined amount of voting power;</li>
                    <li>they vote for participants that will perform block-production duties;</li>
                    <li>selected participants operate according to the protocol\'s schedule or rules;</li>
                    <li>they may receive rewards for correct operation;</li>
                    <li>token holders can change their votes according to the network\'s governance mechanism.</li>
                </ol>

                <p>DPoS can limit the number of active block producers, which may simplify coordination and support higher throughput in a particular architecture. At the same time, the distribution of influence depends on how voting works and how widely tokens and voting rights are distributed.</p>

                <p>DPoS should be distinguished from the general concept of <span class="term" data-term="staking/delegation">delegation</span>. Delegation can be one operation within a PoS system, while DPoS describes a broader consensus architecture in which token-holder voting is used to select block producers.</p>'
            ],
        ],
    ],

    'security' => [
        'title' => 'Cryptocurrency Security Terms',
        'description' => 'Crypto security glossary covering private keys, seed phrases, 2FA, multisig, cold storage and other security terms.',
        'name' => 'Security',
        'caption' => 'Terms related to cryptocurrency and blockchain security, including private keys, seed phrases, 2FA, multisig, cold storage and other concepts.',
        'terms' => [
            'crypto-security' => [
                'title' => 'What Is Crypto Security | TM Wiki',
                'description' => 'Crypto security covers the protection of assets, wallets, transactions, accounts, smart contracts, and blockchain infrastructure.',
                'name' => 'Crypto Security',
                'caption' => 'Protecting crypto assets, wallets, and blockchain systems',
                'definition' => '<p><strong>Crypto security</strong> is the collection of technologies, practices, and operational controls used to protect <span class="term" data-term="cryptocurrency/crypto-asset">crypto assets</span>, wallets, accounts, transactions, smart contracts, and blockchain infrastructure from theft, unauthorized access, manipulation, and other attacks.</p>

                <p>Unlike traditional financial systems, cryptocurrency security often depends directly on the asset holder. Losing a <span class="term" data-term="crypto-wallets/private-key">private key</span> or <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span> can permanently remove access to funds when no alternative recovery mechanism exists.</p>

                <p>Crypto security operates at several levels. At the blockchain level, <span class="term" data-term="blockchain/consensus">consensus</span>, network security, and transaction validation are critical. At the user level, <span class="term" data-term="crypto-wallets/self-custody">self-custody</span>, key protection, and authentication matter. At the application level, smart-contract security, access control, and code review are essential.</p>

                <h3>Main security layers</h3>

                <ul>
                    <li><strong>Blockchain security</strong> — protection of the <span class="term" data-term="blockchain/chain">blockchain chain</span>, consensus mechanism, and network nodes.</li>
                    <li><strong>Wallet security</strong> — protection of private keys, seed phrases, and devices used for <span class="term" data-term="crypto-wallets/transaction-signing">transaction signing</span>.</li>
                    <li><strong>Account security</strong> — protection of accounts through authentication and additional security factors.</li>
                    <li><strong>Application security</strong> — identification and mitigation of vulnerabilities in dApps, exchanges, and smart contracts.</li>
                </ul>

                <p>Common threats include <span class="term" data-term="security/phishing">phishing</span>, <span class="term" data-term="security/social-engineering">social engineering</span>, brute-force attacks, key theft, malware, and attacks against blockchain consensus such as <span class="term" data-term="security/51-percent-attack">51% attacks</span> and <span class="term" data-term="security/sybil-attack">Sybil attacks</span>.</p>

                <p>Crypto security is therefore not a single technology. It is a layered security model in which protocol security, software security, infrastructure security, and user behavior all affect the final level of protection.</p>'
            ],

            '51-percent-attack' => [
                'title' => 'What Is a 51% Attack | TM Wiki',
                'description' => 'A 51% attack occurs when an entity controls most of a blockchain consensus resource and can influence transaction ordering.',
                'name' => '51% Attack',
                'caption' => 'Majority control over a blockchain consensus resource',
                'definition' => '<p>A <strong>51% attack</strong> is a situation in which one participant or a coordinated group controls a majority of the resource used to determine <span class="term" data-term="blockchain/consensus">blockchain consensus</span>. In <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span> networks, this resource is typically computational power. In <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span> systems, an analogous threat involves controlling a large share of the <span class="term" data-term="staking/staking">stake</span>, although the exact attack model depends on the protocol.</p>

                <p>Majority control does not automatically provide complete control over a blockchain. An attacker normally cannot arbitrarily create coins, forge other users\' signatures, or modify data that has already achieved strong finality. The primary risk is the ability to influence the production and ordering of new <span class="term" data-term="blockchain/block">blocks</span> and compete with the honest chain.</p>

                <h3>Potential attacker capabilities</h3>

                <ul>
                    <li>attempting <span class="term" data-term="security/double-spending">double-spending</span> under suitable conditions;</li>
                    <li>censoring or delaying selected transactions;</li>
                    <li>influencing transaction ordering;</li>
                    <li>creating a competing chain and causing reorganizations where the protocol permits them.</li>
                </ul>

                <p>The best-known scenario involves double-spending. An attacker makes a payment on one chain and then uses its controlled consensus resource to build an alternative history in which the payment does not exist. If the alternative chain becomes preferred under the protocol rules, the recipient may lose the basis for treating the original payment as final.</p>

                <p>Protection depends on network architecture. In PoW, the distribution of <span class="term" data-term="mining/hashrate">hashrate</span> and the economic cost of obtaining significant computational power are important. In PoS, the economic cost of controlling stake, <span class="term" data-term="staking/slashing">slashing</span>, finality, and other protocol mechanisms play a major role.</p>

                <p>The risk is particularly relevant to smaller networks where acquiring a large share of the consensus resource may be economically easier. Decentralization and broad resource distribution are therefore important elements of blockchain security.</p>'
            ],

            'double-spending' => [
                'title' => 'What Is Double-Spending | TM Wiki',
                'description' => 'Double-spending is an attempt to use the same cryptocurrency funds more than once in conflicting transactions.',
                'name' => 'Double-Spending',
                'caption' => 'Attempting to spend the same funds twice',
                'definition' => '<p><strong>Double-spending</strong> is an attempt to use the same units of cryptocurrency more than once. Because digital information can be copied, a blockchain must determine which conflicting <span class="term" data-term="blockchain/transaction">transaction</span> is valid and which one should be rejected.</p>

                <p>Blockchains prevent double-spending through <span class="term" data-term="blockchain/consensus">consensus</span>. Network nodes verify whether funds are available and process transactions according to protocol rules. Once a transaction is included in a <span class="term" data-term="blockchain/block">block</span> and receives sufficient confirmations, the probability of replacing it normally decreases.</p>

                <h3>How double-spending can occur</h3>

                <p>An attacker may attempt to send the same amount to two recipients or create an alternative blockchain history after making a payment. Under normal operation, conflicting transactions cannot both spend the same underlying resource. One must be rejected, become invalid, or fail to become part of the accepted chain.</p>

                <p>A major scenario involves a <span class="term" data-term="security/51-percent-attack">51% attack</span>, where an attacker obtains substantial control over block production. Other scenarios can involve network-level attacks or weaknesses in finality mechanisms.</p>

                <p>Double-spending is different from an ordinary user mistake. Sending funds to the wrong <span class="term" data-term="crypto-wallets/wallet-address">wallet address</span> is not double-spending. It is a valid transaction that the sender wishes they could reverse. Double-spending specifically involves attempting to have multiple conflicting expenditures of the same balance recognized.</p>

                <p>Preventing double-spending is one of the fundamental problems solved by blockchain systems. The security of the <span class="term" data-term="blockchain/consensus-mechanism">consensus mechanism</span>, participant distribution, and finality rules therefore directly affect the reliability of a cryptocurrency network.</p>'
            ],

            'sybil-attack' => [
                'title' => 'What Is a Sybil Attack | TM Wiki',
                'description' => 'A Sybil attack creates many fake identities or nodes to gain disproportionate influence over a distributed network.',
                'name' => 'Sybil Attack',
                'caption' => 'Creating many fake participants in a network',
                'definition' => '<p>A <strong>Sybil attack</strong> occurs when an attacker creates many pseudonymous identities, accounts, or network nodes in order to gain more influence over a distributed system than would be justified by the attacker\'s actual resources.</p>

                <p>The problem exists because a large number of network identities does not necessarily represent a large number of independent operators. One entity may control hundreds or thousands of nodes. Blockchain systems therefore need a mechanism that links influence to a scarce computational or economic resource.</p>

                <p>In <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, protection comes from the computational resources required to produce blocks. In <span class="term" data-term="staking/proof-of-stake">Proof-of-Stake</span>, influence is generally connected to <span class="term" data-term="staking/staking">stake</span>. Simply creating many accounts does not provide proportional consensus weight when influence requires corresponding economic resources.</p>

                <h3>Why Sybil attacks matter</h3>

                <p>A Sybil attack can be used to manipulate distributed systems, voting mechanisms, peer selection, or data propagation. In a blockchain, its impact depends on network architecture and on how the protocol determines the weight of participants.</p>

                <p>A Sybil attack alone does not necessarily give an attacker control over a blockchain. If influence is determined by <span class="term" data-term="mining/hashrate">hashrate</span> or stake, thousands of identities without the corresponding resource may have little effect. Sybil attacks can nevertheless amplify other attack types, particularly network-level attacks.</p>

                <p>Resistance to Sybil attacks is therefore a fundamental consideration when designing a blockchain <span class="term" data-term="blockchain/consensus-mechanism">consensus mechanism</span> and network infrastructure.</p>'
            ],

            'eclipse-attack' => [
                'title' => 'What Is an Eclipse Attack | TM Wiki',
                'description' => 'An eclipse attack isolates a blockchain node from honest network participants by surrounding it with attacker-controlled connections.',
                'name' => 'Eclipse Attack',
                'caption' => 'Isolating a node from the honest network',
                'definition' => '<p>An <strong>eclipse attack</strong> is a network-level attack in which an attacker attempts to surround a particular <span class="term" data-term="blockchain/blockchain-node">blockchain node</span> with attacker-controlled connections. The victim may then stop receiving reliable information from the rest of the network.</p>

                <p>A blockchain node depends on network connections to receive blocks, transactions, and other information. If most or all of its available connections are controlled by an attacker, the node may receive a manipulated view of the network state.</p>

                <p>Eclipse attacks are particularly dangerous as an enabling mechanism. Isolating a node does not by itself provide complete control over the blockchain, but it can make other attacks easier. An attacker may hide specific <span class="term" data-term="blockchain/transaction">transactions</span> or blocks from the victim or create conditions that cause the node to make incorrect decisions.</p>

                <h3>Protection</h3>

                <ul>
                    <li>maintaining a large and diverse peer set;</li>
                    <li>avoiding excessive dependence on a single source of peer addresses;</li>
                    <li>randomizing and periodically changing connections;</li>
                    <li>checking important information through independent peers.</li>
                </ul>

                <p>An eclipse attack demonstrates that blockchain security depends on more than cryptography and <span class="term" data-term="blockchain/consensus">consensus</span>. Reliable network infrastructure is also part of the overall security model.</p>'
            ],

            'replay-attack' => [
                'title' => 'What Is a Replay Attack | TM Wiki',
                'description' => 'A replay attack reuses a previously valid signed transaction or message in another context or at a later time.',
                'name' => 'Replay Attack',
                'caption' => 'Reusing previously valid signed data',
                'definition' => '<p>A <strong>replay attack</strong> occurs when an attacker reuses a previously captured and valid message, signature, or <span class="term" data-term="blockchain/transaction">transaction</span> to cause an operation to be executed again.</p>

                <p>A <span class="term" data-term="security/digital-signature">digital signature</span> proves that a particular set of data was signed by the corresponding key, but a signature alone does not necessarily guarantee that the message can only be used once. A protocol must include context, uniqueness, and state information to prevent unintended reuse.</p>

                <p>Blockchain replay protection may use transaction inputs, nonces, network identifiers, chain identifiers, or other fields. These mechanisms distinguish a new operation from one that has already been processed.</p>

                <p>Replay risks are particularly well known when one blockchain splits into two networks after a <span class="term" data-term="blockchain/hard-fork">hard fork</span>. If the transaction formats and signature rules do not sufficiently distinguish the chains, a transaction valid on one network may potentially be replayed on the other.</p>

                <p>Replay protection is therefore part of transaction-format design, <span class="term" data-term="security/digital-signature">digital-signature</span> design, and the rules of the specific blockchain.</p>'
            ],

            'man-in-the-middle' => [
                'title' => 'What Is a Man-in-the-Middle Attack | TM Wiki',
                'description' => 'A man-in-the-middle attack intercepts or modifies communication between two parties without their knowledge.',
                'name' => 'Man-in-the-Middle',
                'caption' => 'Intercepting and modifying communications',
                'definition' => '<p>A <strong>Man-in-the-Middle (MitM)</strong> attack occurs when an attacker positions themselves between two communicating parties and attempts to read, modify, or replace the data being exchanged.</p>

                <p>In cryptocurrency infrastructure, MitM attacks can target exchange websites, wallet connections, application interfaces, network connections, or communications between infrastructure components. The objective may include stealing credentials, replacing a destination address, or altering information presented to a user.</p>

                <p>One major protection mechanism is <span class="term" data-term="security/encryption">encryption</span> of the communication channel combined with proper authentication of the remote party. Encryption alone is not sufficient if a user accepts a fraudulent certificate, installs malicious software, or ignores security warnings.</p>

                <p>Address replacement is particularly dangerous in cryptocurrency transactions. An attacker may attempt to replace a <span class="term" data-term="crypto-wallets/wallet-address">wallet address</span> before the user signs a transaction. Critical transaction details should therefore be verified on a trusted device whenever possible.</p>

                <p>A MitM attack differs from <span class="term" data-term="security/phishing">phishing</span>. Phishing often tricks the user into voluntarily providing information to the attacker, while a MitM attack attempts to interfere directly with the communication channel.</p>'
            ],

            'phishing' => [
                'title' => 'What Is Crypto Phishing | TM Wiki',
                'description' => 'Phishing tricks users into revealing private data, seed phrases, passwords, authentication codes, or access to crypto assets.',
                'name' => 'Phishing',
                'caption' => 'Fake websites and messages designed to steal data',
                'definition' => '<p><strong>Phishing</strong> is an attack in which an attacker creates a false appearance of trust in order to make a user reveal sensitive information or perform a dangerous action. In cryptocurrency, common targets include <span class="term" data-term="crypto-wallets/seed-phrase">seed phrases</span>, <span class="term" data-term="crypto-wallets/private-key">private keys</span>, passwords, and authentication codes.</p>

                <p>Phishing can use fake exchange websites, wallet interfaces, emails, messaging apps, advertisements, or social-media links. The malicious resource may closely imitate the design and behavior of the legitimate service.</p>

                <h3>Common warning signs</h3>

                <ul>
                    <li>unexpected requests to urgently verify an account;</li>
                    <li>a domain name that resembles the legitimate service but contains subtle differences;</li>
                    <li>requests for a seed phrase or private key;</li>
                    <li>offers of free tokens or unusually high returns in exchange for connecting a wallet;</li>
                    <li>pressure based on account suspension or supposed security incidents.</li>
                </ul>

                <p>A legitimate cryptocurrency service should not normally require users to reveal a private key or seed phrase for routine wallet access. These secrets are central to <span class="term" data-term="security/private-key-security">private-key security</span> and <span class="term" data-term="security/seed-phrase-security">seed-phrase security</span>.</p>

                <p>Phishing frequently overlaps with <span class="term" data-term="security/social-engineering">social engineering</span>. Technical account protections should therefore be combined with careful verification of websites, messages, applications, and the identity of people requesting sensitive actions.</p>'
            ],

            'social-engineering' => [
                'title' => 'What Is Social Engineering | TM Wiki',
                'description' => 'Social engineering manipulates people into providing access, credentials, keys, or sensitive information to an attacker.',
                'name' => 'Social Engineering',
                'caption' => 'Manipulating users instead of directly breaking systems',
                'definition' => '<p><strong>Social engineering</strong> is a collection of techniques in which an attacker uses psychological or social manipulation to persuade a person to disclose information, grant access, or perform an unsafe action.</p>

                <p>Social engineering is particularly dangerous in cryptocurrency because many blockchain transactions cannot be reversed. If a user voluntarily reveals a <span class="term" data-term="crypto-wallets/private-key">private key</span> or <span class="term" data-term="crypto-wallets/seed-phrase">seed phrase</span>, the blockchain itself generally cannot restore control to the legitimate owner.</p>

                <p>An attacker may impersonate an exchange employee, developer, moderator, technical-support agent, or acquaintance. They may create artificial urgency, promise compensation, threaten account suspension, or claim that suspicious activity has been detected.</p>

                <h3>Common scenarios</h3>

                <ul>
                    <li>fake technical support;</li>
                    <li>impersonation of project administrators;</li>
                    <li>fraudulent token or investment offers;</li>
                    <li>requests for authentication codes or seed phrases;</li>
                    <li>persuading users to install remote-access software.</li>
                </ul>

                <p>Protection depends heavily on verification procedures. A person should not be considered legitimate merely because their username, profile picture, or message appears official. Critical actions should be verified through an independent communication channel.</p>

                <p>Social engineering is closely related to <span class="term" data-term="security/phishing">phishing</span>, but the concept is broader. Phishing is one specific form of deception, while social engineering includes many different methods of manipulating human behavior.</p>'
            ],

            'private-key-security' => [
                'title' => 'How to Protect a Private Key | TM Wiki',
                'description' => 'Private-key security protects the cryptographic secret that controls crypto assets from theft, copying, and unauthorized disclosure.',
                'name' => 'Private-Key Security',
                'caption' => 'Protecting the key that controls crypto assets',
                'definition' => '<p><strong>Private-key security</strong> is the set of practices used to protect the secret cryptographic key that allows a user to control crypto assets and create <span class="term" data-term="security/digital-signature">digital signatures</span>.</p>

                <p>A private key is not simply a password. It is a cryptographic secret associated with a corresponding <span class="term" data-term="crypto-wallets/public-key">public key</span>. In many blockchains, a transaction is authorized when its signature can be correctly verified using the corresponding public key.</p>

                <p>The central security principle is that a private key must not be disclosed to third parties. If an attacker obtains a copy of the key, they may be able to create valid signatures and, depending on the protocol, transfer assets without the owner\'s additional approval.</p>

                <h3>Key protection measures</h3>

                <ul>
                    <li>keeping keys in a trusted environment;</li>
                    <li>using a <span class="term" data-term="crypto-wallets/hardware-wallet">hardware wallet</span> for significant holdings;</li>
                    <li>avoiding plaintext copies in cloud storage, email, or messaging applications;</li>
                    <li>protecting physical backups from unauthorized access;</li>
                    <li>verifying transaction details before signing.</li>
                </ul>

                <p>Loss and compromise are different events. If a private key is lost, the owner may lose the ability to authorize transactions. If it is compromised, an attacker may gain control. Therefore wallet backup and protection against disclosure must be addressed together.</p>

                <p>Private-key security is fundamental to <span class="term" data-term="crypto-wallets/self-custody">self-custody</span> and is closely connected to seed-phrase security when wallet keys are derived from a seed using a <span class="term" data-term="crypto-wallets/derivation-path">derivation path</span>.</p>'
            ],

            'seed-phrase-security' => [
                'title' => 'How to Protect a Seed Phrase | TM Wiki',
                'description' => 'Seed-phrase security protects the wallet recovery secret from theft, disclosure, destruction, and unauthorized use.',
                'name' => 'Seed-Phrase Security',
                'caption' => 'Protecting the master recovery secret of a wallet',
                'definition' => '<p><strong>Seed-phrase security</strong> is the set of measures used to protect the mnemonic phrase that can be used to recover a cryptocurrency wallet and its associated keys.</p>

                <p>A seed phrase, also called a <span class="term" data-term="crypto-wallets/mnemonic-phrase">mnemonic phrase</span>, is a sequence of words from which a wallet can derive cryptographic keys. Depending on the standard and implementation, one phrase can provide access to many <span class="term" data-term="crypto-wallets/private-key">private keys</span> and wallet addresses.</p>

                <p>A seed phrase should therefore be treated as a master recovery secret. Its compromise can be more significant than the loss of one individual private key because a single phrase may allow an attacker to reconstruct an entire hierarchy of keys.</p>

                <h3>Storage principles</h3>

                <ul>
                    <li>do not store the seed phrase in email, messaging apps, or public cloud storage;</li>
                    <li>do not enter it into random websites or unknown applications;</li>
                    <li>never provide it to customer support or another person;</li>
                    <li>maintain a durable physical backup and protect it from theft and damage;</li>
                    <li>verify word order and any additional recovery parameters.</li>
                </ul>

                <p>A seed phrase should not be confused with a wallet password. A password may protect an application on a particular device, while the seed phrase can usually restore the underlying keys on another compatible device.</p>

                <p>The seed phrase should be treated as a secret comparable in importance to a complete set of private keys. Any unexpected request to enter it is a major warning sign, especially when associated with <span class="term" data-term="security/phishing">phishing</span> or <span class="term" data-term="security/social-engineering">social engineering</span>.</p>'
            ],

            'encryption' => [
                'title' => 'What Is Encryption | TM Wiki',
                'description' => 'Encryption transforms data into an unreadable form without the appropriate key and protects information during storage or transmission.',
                'name' => 'Encryption',
                'caption' => 'Protecting data from unauthorized reading',
                'definition' => '<p><strong>Encryption</strong> is the transformation of readable data into an encoded form using an algorithm and key so that the original information cannot be practically recovered without the appropriate key.</p>

                <p>Encryption is used to protect data both during transmission and while stored. In cryptocurrency infrastructure, it can protect network communications, wallet files, backups, and other sensitive information.</p>

                <p>Encryption must be distinguished from <span class="term" data-term="security/hash-function">hashing</span>. Encryption is designed to be reversible when the correct key is available, while a cryptographic hash is normally a one-way transformation producing a fixed-size output.</p>

                <h3>Main categories</h3>

                <ul>
                    <li><strong>Symmetric encryption</strong> uses the same secret key for encryption and decryption.</li>
                    <li><strong>Asymmetric cryptography</strong> uses a key pair and is used, among other things, for digital signatures and secure communication protocols.</li>
                </ul>

                <p>Encryption does not guarantee security by itself. If the encryption key is stolen, an attacker may be able to decrypt the protected data. Key management is therefore as important as the encryption algorithm.</p>

                <p>Cryptocurrency users should also distinguish encryption from blockchain transaction security. Public blockchain data is generally not hidden by encryption. Its integrity and authorization are provided through mechanisms such as <span class="term" data-term="security/digital-signature">digital signatures</span> and <span class="term" data-term="security/cryptographic-hash">cryptographic hashes</span>.</p>'
            ],

            'hash-function' => [
                'title' => 'What Is a Hash Function | TM Wiki',
                'description' => 'A hash function maps arbitrary data to a fixed-size value and is widely used in blockchain systems and cryptography.',
                'name' => 'Hash Function',
                'caption' => 'Converting data into a fixed-size fingerprint',
                'definition' => '<p>A <strong>hash function</strong> is a mathematical function that converts input data of arbitrary length into a fixed-size output called a hash or digest.</p>

                <p>For cryptographic applications, important properties include resistance to recovering suitable input data from a hash, finding different inputs with the same output, and finding an input that produces a chosen output. The exact security properties depend on the algorithm.</p>

                <p>Hash functions are widely used in <span class="term" data-term="blockchain/blockchain">blockchains</span>. They contribute to block identifiers, links between blocks, data verification, and various consensus mechanisms. In <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, hash computation is the basis of the process used to search for valid block solutions.</p>

                <p>Ordinary hash functions must be distinguished from <span class="term" data-term="security/cryptographic-hash">cryptographic hash functions</span>. Not every hash function provides the properties required to resist deliberate attacks.</p>

                <h3>Important properties</h3>

                <ul>
                    <li>deterministic output;</li>
                    <li>efficient computation;</li>
                    <li>difficulty of recovering suitable input data;</li>
                    <li>difficulty of finding collisions;</li>
                    <li>strong sensitivity to changes in the input.</li>
                </ul>

                <p>Even a small change in the input normally produces a completely different hash. This makes hashes useful as digital fingerprints and allows blockchain systems to cryptographically link elements of a <span class="term" data-term="blockchain/chain">chain</span>.</p>'
            ],

            'cryptographic-hash' => [
                'title' => 'What Is a Cryptographic Hash | TM Wiki',
                'description' => 'A cryptographic hash is a one-way digital fingerprint used to verify data integrity and build cryptographic systems.',
                'name' => 'Cryptographic Hash',
                'caption' => 'A digital fingerprint for cryptographic applications',
                'definition' => '<p>A <strong>cryptographic hash</strong> is the output produced by applying a cryptographic <span class="term" data-term="security/hash-function">hash function</span> to data. It represents the input as a fixed-size value and is used for integrity verification, data structures, and other cryptographic mechanisms.</p>

                <p>A secure cryptographic hash function should make it computationally impractical to recover suitable original data from the hash alone. It should also be difficult to find two different inputs that produce the same result, known as a collision.</p>

                <p>Hashes are fundamental to blockchains. For example, a previous block\'s hash may be included in the <span class="term" data-term="blockchain/block-header">header of the next block</span>, creating a cryptographic connection between blocks. Changing historical data changes the corresponding hash and breaks this relationship.</p>

                <p>In <span class="term" data-term="mining/proof-of-work">Proof-of-Work</span>, cryptographic hashes are used to search for values satisfying a network-defined difficulty condition. This creates the computational cost associated with block production.</p>

                <p>Cryptographic hashes are also used together with <span class="term" data-term="security/digital-signature">digital signatures</span>. Instead of signing a large data set directly, systems can often sign a compact cryptographic representation of that data.</p>'
            ],

            'digital-signature' => [
                'title' => 'What Is a Digital Signature | TM Wiki',
                'description' => 'A digital signature proves control of a private key and allows others to verify the authorship and integrity of signed data.',
                'name' => 'Digital Signature',
                'caption' => 'Cryptographic proof of authorization and integrity',
                'definition' => '<p>A <strong>digital signature</strong> is a cryptographic mechanism that allows one party to prove that specific data was signed using the corresponding <span class="term" data-term="crypto-wallets/private-key">private key</span> and that the signed data has not been modified.</p>

                <p>A typical scheme uses a key pair. The private key remains secret, while the <span class="term" data-term="crypto-wallets/public-key">public key</span> is available for verification. The signer creates a signature using the private key, and other participants can verify it using the public key.</p>

                <p>In blockchains, digital signatures are fundamental to the authorization of many <span class="term" data-term="blockchain/transaction">transactions</span>. A wallet creates the transaction data, signs it, and the network verifies the signature before accepting the transaction.</p>

                <p>A signature does not hide the transaction contents. Authorization, integrity, and confidentiality are separate properties. A digital signature establishes authorship and protects against undetected modification of signed data, but it does not automatically make the data private.</p>

                <h3>Signature security</h3>

                <p>Digital-signature security depends on the cryptographic algorithm, implementation, and protection of the private key. If an attacker obtains the private key, they may be able to create signatures that the network considers valid.</p>

                <p>Digital signatures are therefore closely connected to <span class="term" data-term="security/private-key-security">private-key security</span>, hardware wallets, and <span class="term" data-term="crypto-wallets/transaction-signing">transaction signing</span>.</p>'
            ],

            'zero-knowledge-proof' => [
                'title' => 'What Is a Zero-Knowledge Proof | TM Wiki',
                'description' => 'A Zero-Knowledge Proof lets one party prove a statement is true without revealing the underlying secret or full information.',
                'name' => 'Zero-Knowledge Proof',
                'caption' => 'Proving knowledge without revealing the secret',
                'definition' => '<p>A <strong>Zero-Knowledge Proof (ZKP)</strong> is a cryptographic method that allows one party to prove to another that a statement is true without revealing the secret or underlying information on which the statement is based.</p>

                <p>At a high level, a prover and a verifier participate in the protocol. The prover possesses some secret or satisfies a particular condition and generates a proof. The verifier can check the proof without learning the secret itself.</p>

                <p>In blockchain systems, ZKPs are used for scalability, privacy, and verifiable computation. A proof can, for example, demonstrate that certain conditions were satisfied without publishing all of the underlying data.</p>

                <h3>Example use case</h3>

                <p>Suppose a system needs to verify that a user possesses a certain authorization or satisfies a requirement. Instead of revealing the secret itself, the user can provide a proof that allows the system to verify the claim without learning the underlying information.</p>

                <p>ZKPs differ from <span class="term" data-term="security/encryption">encryption</span>. Encryption protects data from being read without the key, while a zero-knowledge proof allows a party to prove a statement without revealing the corresponding secret.</p>

                <p>Practical ZKP systems may involve complex requirements for computation, proof size, setup assumptions, and cryptographic security. Their exact properties therefore depend on the specific protocol and implementation.</p>

                <p>Zero-Knowledge Proof technology is an important part of modern cryptography and is used by various blockchain systems for privacy and scalability.</p>'
            ],

            'cryptojacking' => [
                'title' => 'What Is Cryptojacking | TM Wiki',
                'description' => 'Cryptojacking is the unauthorized use of another person\'s device or computing resources to mine cryptocurrency.',
                'name' => 'Cryptojacking',
                'caption' => 'Unauthorized use of computing resources for mining',
                'definition' => '<p><strong>Cryptojacking</strong> is the unauthorized use of another person\'s computer, server, mobile device, or cloud infrastructure for <span class="term" data-term="mining/mining">cryptocurrency mining</span>.</p>

                <p>An attacker may install malicious software or inject mining code into a website or application. The compromised device then performs mining computations, increasing CPU or GPU utilization without the owner\'s consent.</p>

                <p>Unlike legitimate mining, the victim does not receive the economic benefit from the computation. Cryptojacking can increase electricity costs, reduce performance, increase operating temperatures, and accelerate hardware wear.</p>

                <h3>Common signs</h3>

                <ul>
                    <li>unexpectedly high CPU or GPU utilization;</li>
                    <li>increased power consumption;</li>
                    <li>unknown processes running continuously;</li>
                    <li>higher device temperatures and fan activity;</li>
                    <li>unusual network activity.</li>
                </ul>

                <p>Protection includes keeping software updated, using endpoint security tools, limiting application permissions, monitoring processes, and detecting abnormal infrastructure behavior. Data centers and large operators can also monitor anomalies in <span class="term" data-term="equipment-specifications/power-consumption">power consumption</span> and system load.</p>

                <p>Cryptojacking differs from ordinary mining because the economic benefit of the computation goes to an unauthorized third party rather than the owner of the hardware.</p>'
            ],

            'smart-contract-audit' => [
                'title' => 'What Is a Smart Contract Audit | TM Wiki',
                'description' => 'A smart contract audit reviews contract code for vulnerabilities, logic errors, access-control issues, and other security risks.',
                'name' => 'Smart Contract Audit',
                'caption' => 'Reviewing smart-contract code for vulnerabilities',
                'definition' => '<p>A <strong>smart contract audit</strong> is a systematic review of <span class="term" data-term="blockchain/smart-contract">smart-contract</span> source code intended to identify vulnerabilities, logic errors, access-control problems, and other issues that could cause loss of funds or unexpected protocol behavior.</p>

                <p>Auditing is particularly important for contracts that manage large amounts of capital. This includes <span class="term" data-term="defi/liquidity-pool">liquidity pools</span>, lending protocols, bridges, staking systems, and other <span class="term" data-term="defi/defi">DeFi</span> applications.</p>

                <h3>What an audit may examine</h3>

                <ul>
                    <li>access control and administrative functions;</li>
                    <li>mathematical calculations and balance handling;</li>
                    <li>input validation and edge cases;</li>
                    <li>repeated execution and state-transition issues;</li>
                    <li>economic attack scenarios and incorrect protocol assumptions;</li>
                    <li>integrations with <span class="term" data-term="defi/oracle">oracles</span> and other contracts;</li>
                    <li>ways in which funds could become locked, drained, or incorrectly allocated.</li>
                </ul>

                <p>An audit may combine manual code review, automated static-analysis tools, testing, and simulation of potential attacks. Automated tools are useful for identifying classes of defects, but they cannot guarantee that all logical or economic vulnerabilities will be found.</p>

                <p>An audit report does not mean that a smart contract is absolutely safe. The code may change after the audit, new attack techniques may emerge, or a vulnerability may exist outside the scope of the review.</p>

                <p>Users of <span class="term" data-term="defi/decentralized-finance">decentralized finance</span> applications should therefore consider not only whether an audit exists, but also its scope, date, reviewed contract version, stated limitations, and subsequent protocol changes.</p>'
            ],
        ],
    ],

];
